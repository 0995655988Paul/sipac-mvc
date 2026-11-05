<?php

namespace App\Controllers;

use App\Models\DetallePlanModel;
use App\Models\PlanCompraModel;
use App\Models\PresupuestoModel;
use App\Models\ProductoModel;
use App\Services\InventarioService;
use App\Services\PlanificacionService;
use App\Services\PronosticoService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Planificacion extends BaseController
{
    public function index()
    {
        $planes = db_connect()->table('planes_compra p')->select('p.*,b.periodo,b.monto_autorizado,u.nombre AS creador,COUNT(dp.id) AS productos,SUM(dp.costo_estimado) AS total_estimado')
            ->join('presupuestos b', 'b.id = p.presupuesto_id')->join('usuarios u', 'u.id = p.usuario_id')->join('detalles_plan dp', 'dp.plan_id = p.id', 'left')
            ->groupBy('p.id')->orderBy('p.id', 'DESC')->get()->getResultArray();
        return view('planificacion/index', ['titulo' => 'Planificación de compras', 'planes' => $planes]);
    }

    public function nuevo()
    {
        return view('planificacion/formulario', [
            'titulo' => 'Generar plan de compra',
            'presupuestos' => (new PresupuestoModel())->orderBy('periodo', 'DESC')->findAll(),
            'productos' => (new ProductoModel())->where('activo', 1)->orderBy('nombre')->findAll(),
            'saldos' => (new InventarioService())->saldos(),
            'errores' => [],
            'datos' => ['presupuesto_id' => '', 'fecha_corte' => date('Y-m-d'), 'productos' => [['producto_id' => '', 'historial' => '80, 90, 100']]],
        ]);
    }

    public function guardar()
    {
        $presupuestoId = (int) $this->request->getPost('presupuesto_id');
        $fechaCorte = trim((string) $this->request->getPost('fecha_corte'));
        $productoIds = $this->request->getPost('producto_id');
        $historiales = $this->request->getPost('historial');
        $detallesCotizacion = $this->request->getPost('detalle_cotizacion_id');
        $productoIds = is_array($productoIds) ? $productoIds : [];
        $historiales = is_array($historiales) ? $historiales : [];
        $detallesCotizacion = is_array($detallesCotizacion) ? $detallesCotizacion : [];
        $datos = ['presupuesto_id' => $presupuestoId, 'fecha_corte' => $fechaCorte, 'productos' => []];
        foreach ($productoIds as $indice => $productoId) {
            $datos['productos'][] = ['producto_id' => (int) $productoId, 'historial' => (string) ($historiales[$indice] ?? ''), 'detalle_cotizacion_id' => (int) ($detallesCotizacion[$indice] ?? 0)];
        }
        $errores = [];
        if ((new PresupuestoModel())->find($presupuestoId) === null) {
            $errores['presupuesto_id'] = 'Selecciona un presupuesto existente.';
        }
        if (! $this->fechaValida($fechaCorte) || $fechaCorte > date('Y-m-d')) {
            $errores['fecha_corte'] = 'La fecha de corte debe ser válida y no posterior a hoy.';
        }
        if (count($productoIds) < 1 || count($productoIds) > 8) {
            $errores['productos'] = 'Un plan debe incluir entre 1 y 8 productos.';
        }

        $vistos = [];
        $saldos = (new InventarioService())->saldos();
        $productos = new ProductoModel();
        $detalles = [];
        foreach ($productoIds as $indice => $productoId) {
            $productoId = (int) $productoId;
            if (isset($vistos[$productoId])) {
                $errores['productos'] = 'No repitas el mismo producto dentro del plan.';
                continue;
            }
            $vistos[$productoId] = true;
            $producto = $productos->where('id', $productoId)->where('activo', 1)->first();
            if ($producto === null) {
                $errores['producto_' . $indice] = 'El producto seleccionado no existe o está inactivo.';
                continue;
            }
            $historial = $this->parsearHistorial((string) ($historiales[$indice] ?? ''));
            if (count($historial) < 3 || count($historial) > 6) {
                $errores['historial_' . $indice] = 'Registra de 3 a 6 consumos mensuales cerrados, separados por coma.';
                continue;
            }
            $consumo = PronosticoService::suavizar($historial);
            $stock = (int) ($saldos[$productoId] ?? 0);
            $detalleCotizacionId = (int) ($detallesCotizacion[$indice] ?? 0);
            $cotizacion = $detalleCotizacionId > 0 ? $this->cotizacionValida($detalleCotizacionId, $productoId) : null;
            if ($detalleCotizacionId > 0 && $cotizacion === null) {
                $errores['detalle_cotizacion_' . $indice] = 'La cotización no corresponde al producto o ya no está vigente.';
            }
            $necesidad = PlanificacionService::necesidad($consumo, (int) $producto['stock_seguridad'], $stock, 0);
            $cantidad = $cotizacion === null ? 0 : min($necesidad, (int) $cotizacion['cantidad_disponible']);
            $costo = $cotizacion === null ? 0 : PlanificacionService::costo($cantidad, (float) $cotizacion['precio_unitario'], (float) $cotizacion['costo_adicional_unitario']);
            $detalles[] = ['producto' => $producto, 'detalle_cotizacion_id' => $cotizacion['id'] ?? null, 'consumo' => $consumo, 'stock' => $stock, 'necesidad' => $necesidad, 'cantidad' => $cantidad, 'costo' => $costo, 'cotizacion' => $cotizacion, 'fecha_necesidad' => date('Y-m-d', strtotime('first day of next month')), 'motivo' => PlanificacionService::motivo($necesidad, $cantidad, $cotizacion), 'historial' => $historial];
        }

        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return $this->formularioConDatos($datos, $errores);
        }

        $db = db_connect();
        $db->transStart();
        $plan = new PlanCompraModel();
        $plan->insert(['presupuesto_id' => $presupuestoId, 'usuario_id' => session('usuario_id'), 'fecha_corte' => $fechaCorte, 'fecha_generacion' => date('Y-m-d H:i:s'), 'estado' => 'BORRADOR', 'parametros_json' => json_encode(['alpha' => PronosticoService::ALPHA, 'historiales' => array_column($detalles, 'historial')], JSON_UNESCAPED_UNICODE), 'version_metodo' => 'SES-alpha-0.3-v1']);
        $planId = $db->insertID();
        $detalleModel = new DetallePlanModel();
        foreach ($detalles as $detalle) {
            $detalleModel->insert(['plan_id' => $planId, 'producto_id' => $detalle['producto']['id'], 'detalle_cotizacion_id' => $detalle['detalle_cotizacion_id'], 'consumo_estimado' => $detalle['consumo'], 'stock_corte' => $detalle['stock'], 'pendiente_a_tiempo' => 0, 'necesidad' => $detalle['necesidad'], 'cantidad_sugerida' => $detalle['cantidad'], 'costo_estimado' => $detalle['costo'], 'fecha_necesidad' => $detalle['fecha_necesidad'], 'prioridad_snapshot' => $detalle['producto']['prioridad'], 'motivo' => $detalle['motivo']]);
        }
        $db->transComplete();
        return redirect()->to(site_url('planificacion/' . $planId))->with('exito', 'Plan generado como borrador. Revísalo antes de aprobarlo.');
    }

    public function detalle(int $id)
    {
        $plan = db_connect()->table('planes_compra p')->select('p.*,b.periodo,b.monto_autorizado,u.nombre AS creador')->join('presupuestos b', 'b.id = p.presupuesto_id')->join('usuarios u', 'u.id = p.usuario_id')->where('p.id', $id)->get()->getRowArray();
        if ($plan === null) {
            throw PageNotFoundException::forPageNotFound('Plan no encontrado.');
        }
        $detalles = db_connect()->table('detalles_plan dp')->select('dp.*,pr.codigo,pr.nombre,pr.unidad,pv.razon_social,pv.identificacion_fiscal,dc.precio_unitario,dc.costo_adicional_unitario,dc.plazo_dias')
            ->join('productos pr', 'pr.id = dp.producto_id')->join('detalle_cotizaciones dc', 'dc.id = dp.detalle_cotizacion_id', 'left')->join('cotizaciones c', 'c.id = dc.cotizacion_id', 'left')->join('proveedores pv', 'pv.id = c.proveedor_id', 'left')->where('dp.plan_id', $id)->get()->getResultArray();
        return view('planificacion/detalle', ['titulo' => 'Detalle del plan', 'plan' => $plan, 'detalles' => $detalles, 'total' => array_sum(array_map(static fn (array $fila): float => (float) $fila['costo_estimado'], $detalles))]);
    }

    public function aprobar(int $id)
    {
        $db = db_connect();
        $plan = (new PlanCompraModel())->find($id);
        if ($plan === null || $plan['estado'] !== 'BORRADOR') {
            return redirect()->to(site_url('planificacion/' . $id))->with('error', 'Solo se puede aprobar un borrador existente.');
        }
        $detalles = $db->table('detalles_plan dp')->select('dp.*,dc.precio_unitario,dc.costo_adicional_unitario,dc.plazo_dias,c.proveedor_id,c.valida_hasta,c.estado')
            ->join('detalle_cotizaciones dc', 'dc.id = dp.detalle_cotizacion_id', 'left')->join('cotizaciones c', 'c.id = dc.cotizacion_id', 'left')->where('dp.plan_id', $id)->get()->getResultArray();
        $total = array_sum(array_map(static fn (array $fila): float => (float) $fila['costo_estimado'], $detalles));
        $autorizado = (float) db_connect()->table('presupuestos')->where('id', $plan['presupuesto_id'])->get()->getRow('monto_autorizado');
        $comprometido = (float) db_connect()->table('ordenes_compra')->selectSum('total')->where('presupuesto_id', $plan['presupuesto_id'])->where('estado !=', 'CANCELADA')->get()->getRow('total');
        if ($total > max(0, $autorizado - $comprometido)) {
            return redirect()->to(site_url('planificacion/' . $id))->with('error', 'La aprobación fue rechazada: el plan supera el presupuesto disponible.');
        }
        foreach ($detalles as $detalle) {
            if ((int) $detalle['necesidad'] > 0 && ((int) $detalle['cantidad_sugerida'] < 1 || $detalle['proveedor_id'] === null || $detalle['valida_hasta'] < date('Y-m-d') || $detalle['estado'] !== 'VIGENTE')) {
                return redirect()->to(site_url('planificacion/' . $id))->with('error', 'La aprobación fue rechazada: existe una necesidad sin oferta vigente suficiente.');
            }
        }

        $grupos = [];
        foreach ($detalles as $detalle) {
            if ((int) $detalle['cantidad_sugerida'] < 1) {
                continue;
            }
            $grupos[(int) $detalle['proveedor_id']][] = $detalle;
        }
        $db->transStart();
        foreach ($grupos as $proveedorId => $filas) {
            $fechaPrometida = date('Y-m-d');
            foreach ($filas as $fila) {
                $prometida = date('Y-m-d', strtotime('+' . (int) $fila['plazo_dias'] . ' days'));
                if ($prometida > $fechaPrometida) {
                    $fechaPrometida = $prometida;
                }
            }
            $totalProveedor = array_sum(array_map(static fn (array $fila): float => (float) $fila['costo_estimado'], $filas));
            $db->table('ordenes_compra')->insert(['proveedor_id' => $proveedorId, 'presupuesto_id' => $plan['presupuesto_id'], 'plan_id' => $id, 'aprobado_por' => session('usuario_id'), 'fecha_emision' => date('Y-m-d'), 'fecha_prometida' => $fechaPrometida, 'estado' => 'EMITIDA', 'total' => $totalProveedor]);
            $ordenId = $db->insertID();
            foreach ($filas as $fila) {
                $db->table('detalles_orden')->insert(['orden_id' => $ordenId, 'producto_id' => $fila['producto_id'], 'cantidad' => $fila['cantidad_sugerida'], 'precio_unitario' => $fila['precio_unitario'], 'costo_adicional_unitario' => $fila['costo_adicional_unitario']]);
            }
        }
        $db->table('escenarios')->insert(['plan_id' => $id, 'nombre' => 'Base aprobada', 'variacion_consumo_pct' => 0, 'variacion_precio_pct' => 0, 'retraso_dias' => 0, 'costo_estimado' => $total, 'brecha' => 0, 'resultado_json' => json_encode(['estado' => 'APROBADO', 'total' => $total])]);
        $db->table('planes_compra')->where('id', $id)->update(['estado' => 'APROBADO']);
        $db->transComplete();
        return redirect()->to(site_url('planificacion/' . $id))->with('exito', 'Plan aprobado y órdenes de compra emitidas.');
    }

    private function formularioConDatos(array $datos, array $errores): string
    {
        return view('planificacion/formulario', ['titulo' => 'Generar plan de compra', 'presupuestos' => (new PresupuestoModel())->orderBy('periodo', 'DESC')->findAll(), 'productos' => (new ProductoModel())->where('activo', 1)->orderBy('nombre')->findAll(), 'saldos' => (new InventarioService())->saldos(), 'errores' => $errores, 'datos' => $datos]);
    }

    private function cotizacionValida(int $detalleId, int $productoId): ?array
    {
        return db_connect()->table('detalle_cotizaciones dc')->select('dc.*,c.proveedor_id,c.valida_hasta,c.estado')->join('cotizaciones c', 'c.id = dc.cotizacion_id')->where('dc.id', $detalleId)->where('dc.producto_id', $productoId)->where('c.estado', 'VIGENTE')->where('c.valida_hasta >=', date('Y-m-d'))->get()->getRowArray();
    }

    private function parsearHistorial(string $texto): array
    {
        $partes = preg_split('/[,;\s]+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        return array_values(array_filter(array_map(static fn (string $valor): int => (int) $valor, $partes), static fn (int $valor): bool => $valor >= 0));
    }

    private function fechaValida(string $fecha): bool
    {
        $d = \DateTimeImmutable::createFromFormat('Y-m-d', $fecha);
        return $d !== false && $d->format('Y-m-d') === $fecha;
    }
}
