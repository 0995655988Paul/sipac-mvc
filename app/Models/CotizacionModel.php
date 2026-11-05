<?php

namespace App\Models;

use CodeIgniter\Model;

class CotizacionModel extends Model
{
    protected $table = 'cotizaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['proveedor_id', 'fecha_emision', 'valida_hasta', 'estado'];
    protected $returnType = 'array';
}
