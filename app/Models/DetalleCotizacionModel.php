<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCotizacionModel extends Model
{
    protected $table = 'detalle_cotizaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cotizacion_id', 'producto_id', 'cantidad_disponible', 'precio_unitario', 'costo_adicional_unitario', 'plazo_dias'];
    protected $returnType = 'array';
}
