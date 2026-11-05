<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

// Rutas para cargar clases y archivos automáticamente.
class Autoload extends AutoloadConfig
{
    /**
     * Ubicación de cada espacio de nombres.
     * @var array<string, list<string>|string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
    ];

    /**
     * Ruta directa de cada clase.
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * Archivos que se cargan al iniciar.
     * @var list<string>
     */
    public $files = [];

    /**
     * Funciones auxiliares que se cargan al iniciar.
     * @var list<string>
     */
    public $helpers = [];
}
