<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoInventarioModel extends Model
{
    protected $table = 'movimientos_inventario';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_id', 'usuario_id', 'detalle_recepcion_id', 'fecha', 'tipo', 'cantidad', 'motivo'];
    protected $returnType = 'array';
}
