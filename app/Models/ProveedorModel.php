<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['razon_social', 'identificacion_fiscal', 'contacto', 'correo', 'telefono', 'activo'];
    protected $returnType = 'array';
}
