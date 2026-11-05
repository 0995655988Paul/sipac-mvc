<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * Vistas de los enlaces de paginación.
     * @var array<string, string>
     */
    public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
    ];

    // Resultados por página.
    public int $perPage = 20;
}
