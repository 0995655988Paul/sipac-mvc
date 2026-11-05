<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanCompraModel extends Model
{
    protected $table = 'planes_compra';
    protected $primaryKey = 'id';
    protected $allowedFields = ['presupuesto_id', 'usuario_id', 'fecha_corte', 'fecha_generacion', 'estado', 'parametros_json', 'version_metodo'];
    protected $returnType = 'array';
}
