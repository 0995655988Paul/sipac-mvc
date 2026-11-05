<?php

namespace Config;

// Rutas de las carpetas del proyecto.
class Paths
{
    // Carpeta del framework.
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * Carpeta de la aplicación.
     * @see http://codeigniter.com/user_guide/general/managing_apps.html
     */
    public string $appDirectory = __DIR__ . '/..';

    // Carpeta con permisos de escritura.
    public string $writableDirectory = __DIR__ . '/../../writable';

    // Carpeta de pruebas.
    public string $testsDirectory = __DIR__ . '/../../tests';

    // Carpeta de vistas.
    public string $viewDirectory = __DIR__ . '/../Views';

    // Carpeta del archivo .env; debe ser privada.
    public string $envDirectory = __DIR__ . '/../../';
}
