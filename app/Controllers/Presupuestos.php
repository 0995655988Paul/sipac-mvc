<?php

namespace App\Controllers;

use App\Models\PresupuestoModel;

class Presupuestos extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $presupuestos = $db->table('presupuestos p')->select("p.*, COALESCE(SUM(CASE WHEN o.estado != 'CANCELADA' THEN o.total ELSE 0 END), 0) AS comprometido")
            ->join('ordenes_compra o', 'o.presupuesto_id = p.id', 'left')->groupBy('p.id')->orderBy('p.periodo', 'DESC')->get()->getResultArray();
        return view('presupuestos/index', ['titulo' => 'Presupuestos', 'presupuestos' => $presupuestos]);
    }

    public function nuevo()
    {
        return view('presupuestos/formulario', ['titulo' => 'Nuevo presupuesto', 'datos' => ['periodo' => date('Y-m'), 'monto_autorizado' => ''], 'errores' => []]);
    }

    public function guardar()
    {
        $datos = ['periodo' => trim((string) $this->request->getPost('periodo')), 'monto_autorizado' => trim((string) $this->request->getPost('monto_autorizado'))];
        $errores = [];
        if (! preg_match('/\A\d{4}-(0[1-9]|1[0-2])\z/', $datos['periodo'])) {
            $errores['periodo'] = 'Usa el formato AAAA-MM.';
        }
        if (! preg_match('/\A\d{1,10}(\.\d{1,2})?\z/', $datos['monto_autorizado']) || (float) $datos['monto_autorizado'] <= 0) {
            $errores['monto_autorizado'] = 'Ingresa un monto positivo con máximo dos decimales.';
        }
        $modelo = new PresupuestoModel();
        if ($modelo->where('periodo', $datos['periodo'])->first() !== null) {
            $errores['periodo'] = 'Ya existe un presupuesto para ese periodo.';
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return view('presupuestos/formulario', ['titulo' => 'Nuevo presupuesto', 'datos' => $datos, 'errores' => $errores]);
        }
        $modelo->insert($datos);
        return redirect()->to(site_url('presupuestos'))->with('exito', 'Presupuesto creado.');
    }
}
