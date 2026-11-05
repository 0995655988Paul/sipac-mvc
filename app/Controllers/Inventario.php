<?php

namespace App\Controllers;

use App\Models\MovimientoInventarioModel;
use App\Models\ProductoModel;
use App\Services\InventarioService;

class Inventario extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $movimientos = $db->table('movimientos_inventario m')->select('m.*,p.codigo,p.nombre,u.nombre AS usuario')
            ->join('productos p', 'p.id = m.producto_id')->join('usuarios u', 'u.id = m.usuario_id')->orderBy('m.id', 'DESC')->limit(30)->get()->getResultArray();
        return view('inventario/index', ['titulo' => 'Inventario', 'productos' => (new ProductoModel())->where('activo', 1)->orderBy('nombre')->findAll(), 'saldos' => (new InventarioService())->saldos(), 'movimientos' => $movimientos, 'errores' => []]);
    }

    public function guardarMovimiento()
    {
        $productoId = (int) $this->request->getPost('producto_id');
        $tipo = (string) $this->request->getPost('tipo');
        $cantidad = (int) $this->request->getPost('cantidad');
        $motivo = trim((string) $this->request->getPost('motivo'));
        $errores = [];
        if ((new ProductoModel())->where('id', $productoId)->where('activo', 1)->first() === null) {
            $errores['producto_id'] = 'Selecciona un producto activo.';
        }
        if (! in_array($tipo, ['entrada', 'consumo', 'ajuste'], true)) {
            $errores['tipo'] = 'Selecciona un tipo válido.';
        }
        if ($cantidad < 1) {
            $errores['cantidad'] = 'La cantidad debe ser un entero positivo.';
        }
        if ($tipo === 'consumo' && $cantidad > (new InventarioService())->saldo($productoId)) {
            $errores['cantidad'] = 'El consumo no puede superar el saldo disponible.';
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return view('inventario/index', ['titulo' => 'Inventario', 'productos' => (new ProductoModel())->where('activo', 1)->orderBy('nombre')->findAll(), 'saldos' => (new InventarioService())->saldos(), 'movimientos' => [], 'errores' => $errores]);
        }
        (new MovimientoInventarioModel())->insert(['producto_id' => $productoId, 'usuario_id' => session('usuario_id'), 'fecha' => date('Y-m-d'), 'tipo' => $tipo, 'cantidad' => $cantidad, 'motivo' => $motivo !== '' ? $motivo : 'Movimiento manual']);
        return redirect()->to(site_url('inventario'))->with('exito', 'Movimiento registrado.');
    }
}
