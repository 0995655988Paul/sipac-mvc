<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePlanModel extends Model
{
    protected $table = 'detalles_plan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['plan_id', 'producto_id', 'detalle_cotizacion_id', 'consumo_estimado', 'stock_corte', 'pendiente_a_tiempo', 'necesidad', 'cantidad_sugerida', 'costo_estimado', 'fecha_necesidad', 'prioridad_snapshot', 'motivo'];
    protected $returnType = 'array';
}
