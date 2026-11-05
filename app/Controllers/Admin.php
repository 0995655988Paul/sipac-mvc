<?php

namespace App\Controllers;

use App\Services\InventarioService;

class Admin extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $saldos = (new InventarioService())->saldos();
        $planes = $db->table('planes_compra p')->select('p.id,p.fecha_generacion,p.estado,b.periodo,b.monto_autorizado')
            ->join('presupuestos b', 'b.id = p.presupuesto_id')->orderBy('p.id', 'DESC')->limit(5)->get()->getResultArray();
        $autorizado = (float) ($db->table('presupuestos')->selectSum('monto_autorizado')->get()->getRow('monto_autorizado') ?? 0);
        $comprometido = (float) ($db->table('ordenes_compra')->selectSum('total')->where('estado !=', 'CANCELADA')->get()->getRow('total') ?? 0);

        return view('admin/panel', [
            'titulo' => 'Panel de administración',
            'metricas' => [
                'productos' => $db->table('productos')->where('activo', 1)->countAllResults(),
                'proveedores' => $db->table('proveedores')->where('activo', 1)->countAllResults(),
                'planes' => $db->table('planes_compra')->countAllResults(),
                'stock' => array_sum($saldos),
            ],
            'planes' => $planes,
            'presupuesto' => ['autorizado' => $autorizado, 'comprometido' => $comprometido, 'disponible' => max(0, $autorizado - $comprometido)],
        ]);
    }
}
