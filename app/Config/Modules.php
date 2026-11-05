<?php

namespace Config;

use CodeIgniter\Modules\Modules as BaseModules;

// Opciones de módulos, cargadas antes del autoloader.
class Modules extends BaseModules
{
    /**
     * Activa la búsqueda automática de módulos.
     * @var bool
     */
    public $enabled = true;

    /**
     * Busca módulos en paquetes de Composer.
     * @var bool
     */
    public $discoverInComposer = true;

    /**
     * Paquetes incluidos o excluidos de la búsqueda.
     * @var array{only?: list<string>, exclude?: list<string>}
     */
    public $composerPackages = [];

    /**
     * Elementos que se detectan automáticamente.
     * @var list<string>
     */
    public $aliases = [
        'events',
        'filters',
        'registrars',
        'routes',
        'services',
    ];
}
