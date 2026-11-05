<?php

namespace App\Controllers;

class Api extends BaseController
{
    public function cotizacionesPorProducto(int $productoId)
    {
        $hoy = date('Y-m-d');
        $filas = db_connect()->table('detalle_cotizaciones dc')->select('dc.id,dc.cantidad_disponible,dc.precio_unitario,dc.costo_adicional_unitario,dc.plazo_dias,c.id AS cotizacion_id,p.razon_social,c.valida_hasta')
            ->join('cotizaciones c', 'c.id = dc.cotizacion_id')->join('proveedores p', 'p.id = c.proveedor_id')
            ->where('dc.producto_id', $productoId)->where('c.estado', 'VIGENTE')->where('c.valida_hasta >=', $hoy)->orderBy('dc.precio_unitario')->get()->getResultArray();
        return $this->response->setJSON(['data' => $filas]);
    }
}
