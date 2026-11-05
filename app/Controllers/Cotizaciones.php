<?php

namespace App\Controllers;

use App\Models\CotizacionModel;
use App\Models\ProductoModel;
use App\Models\ProveedorModel;

class Cotizaciones extends BaseController
{
    public function index()
    {
        $cotizaciones = db_connect()->table('cotizaciones c')->select('c.*,p.razon_social,COUNT(dc.id) AS productos')
            ->join('proveedores p', 'p.id = c.proveedor_id')->join('detalle_cotizaciones dc', 'dc.cotizacion_id = c.id', 'left')
            ->groupBy('c.id')->orderBy('c.valida_hasta', 'DESC')->get()->getResultArray();
        return view('cotizaciones/index', ['titulo' => 'Cotizaciones', 'cotizaciones' => $cotizaciones]);
    }

    public function nuevo()
    {
        return $this->formulario(['fecha_emision' => date('Y-m-d'), 'valida_hasta' => date('Y-m-d', strtotime('+30 days')), 'proveedor_id' => '', 'producto_id' => '', 'cantidad_disponible' => 1, 'precio_unitario' => '', 'costo_adicional_unitario' => '0.00', 'plazo_dias' => 1], []);
    }

    public function guardar()
    {
        $datos = [
            'proveedor_id' => (int) $this->request->getPost('proveedor_id'),
            'producto_id' => (int) $this->request->getPost('producto_id'),
            'fecha_emision' => trim((string) $this->request->getPost('fecha_emision')),
            'valida_hasta' => trim((string) $this->request->getPost('valida_hasta')),
            'cantidad_disponible' => (int) $this->request->getPost('cantidad_disponible'),
            'precio_unitario' => trim((string) $this->request->getPost('precio_unitario')),
            'costo_adicional_unitario' => trim((string) $this->request->getPost('costo_adicional_unitario')),
            'plazo_dias' => (int) $this->request->getPost('plazo_dias'),
        ];
        $errores = [];
        if ((new ProveedorModel())->find($datos['proveedor_id']) === null) {
            $errores['proveedor_id'] = 'Selecciona un proveedor de la lista.';
        }
        if ((new ProductoModel())->where('id', $datos['producto_id'])->where('activo', 1)->first() === null) {
            $errores['producto_id'] = 'Selecciona un producto activo de la lista.';
        }
        if (! $this->fecha($datos['fecha_emision']) || ! $this->fecha($datos['valida_hasta']) || $datos['valida_hasta'] < $datos['fecha_emision']) {
            $errores['valida_hasta'] = 'La vigencia debe ser una fecha válida posterior a la emisión.';
        }
        foreach (['cantidad_disponible' => $datos['cantidad_disponible'], 'plazo_dias' => $datos['plazo_dias']] as $campo => $valor) {
            if ($valor < 1) {
                $errores[$campo] = 'Debe ser un entero positivo.';
            }
        }
        foreach (['precio_unitario', 'costo_adicional_unitario'] as $campo) {
            if (! preg_match('/\A\d{1,10}(\.\d{1,2})?\z/', $datos[$campo]) || (float) $datos[$campo] < 0) {
                $errores[$campo] = 'Ingresa un importe válido con máximo dos decimales.';
            }
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return $this->formulario($datos, $errores);
        }

        $db = db_connect();
        $db->transStart();
        (new CotizacionModel())->insert(['proveedor_id' => $datos['proveedor_id'], 'fecha_emision' => $datos['fecha_emision'], 'valida_hasta' => $datos['valida_hasta'], 'estado' => 'VIGENTE']);
        $cotizacionId = $db->insertID();
        $db->table('detalle_cotizaciones')->insert(['cotizacion_id' => $cotizacionId, 'producto_id' => $datos['producto_id'], 'cantidad_disponible' => $datos['cantidad_disponible'], 'precio_unitario' => $datos['precio_unitario'], 'costo_adicional_unitario' => $datos['costo_adicional_unitario'], 'plazo_dias' => $datos['plazo_dias']]);
        $db->transComplete();
        return redirect()->to(site_url('cotizaciones'))->with('exito', 'Cotización guardada y disponible para planificación.');
    }

    private function formulario(array $datos, array $errores): string
    {
        return view('cotizaciones/formulario', ['titulo' => 'Nueva cotización', 'datos' => $datos, 'errores' => $errores, 'proveedores' => (new ProveedorModel())->where('activo', 1)->orderBy('razon_social')->findAll(), 'productos' => (new ProductoModel())->where('activo', 1)->orderBy('nombre')->findAll()]);
    }

    private function fecha(string $fecha): bool
    {
        $d = \DateTimeImmutable::createFromFormat('Y-m-d', $fecha);
        return $d !== false && $d->format('Y-m-d') === $fecha;
    }
}
