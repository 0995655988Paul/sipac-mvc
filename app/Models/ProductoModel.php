<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'nombre', 'unidad', 'stock_seguridad', 'prioridad', 'activo'];
    protected $returnType = 'array';
    protected $validationRules = [
        'codigo' => 'required|regex_match[/\A[A-Z0-9][A-Z0-9-]{2,19}\z/]',
        'nombre' => 'required|max_length[120]',
        'unidad' => 'required|max_length[30]',
        'stock_seguridad' => 'required|is_natural',
        'prioridad' => 'required|in_list[1,2,3]',
    ];
    protected $validationMessages = [
        'codigo' => ['required' => 'El código es obligatorio.', 'regex_match' => 'Usa de 3 a 20 caracteres: mayúsculas, números y guion.'],
        'nombre' => ['required' => 'El nombre es obligatorio.', 'max_length' => 'El nombre no puede superar 120 caracteres.'],
        'unidad' => ['required' => 'Indica la unidad de compra.'],
        'stock_seguridad' => ['required' => 'Indica el stock de seguridad.', 'is_natural' => 'El stock debe ser un entero igual o mayor a cero.'],
        'prioridad' => ['required' => 'Selecciona una prioridad.', 'in_list' => 'La prioridad debe ser 1, 2 o 3.'],
    ];
}
