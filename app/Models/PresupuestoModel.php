<?php

namespace App\Models;

use CodeIgniter\Model;

class PresupuestoModel extends Model
{
    protected $table = 'presupuestos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['periodo', 'monto_autorizado'];
    protected $returnType = 'array';
}
