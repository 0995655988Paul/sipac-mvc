<?php

/**
 * Parte de CodeIgniter 4.
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 * Licencia y derechos de autor: véase LICENSE.
 */

namespace Config;

use CodeIgniter\Config\Routing as BaseRouting;

/** Configuración de rutas. */
class Routing extends BaseRouting
{
    /**
     * Archivos de rutas: la primera coincidencia tiene prioridad.
     * @var list<string>
     */
    public array $routeFiles = [
        APPPATH . 'Config/Routes.php',
    ];

    /** Namespace predeterminado de los controladores. */
    public string $defaultNamespace = 'App\Controllers';

    /** Controlador predeterminado para las rutas automáticas. */
    public string $defaultController = 'Home';

    /** Método predeterminado del controlador. */
    public string $defaultMethod = 'index';

    /** Convierte guiones de la URL en guiones bajos para las rutas automáticas. */
    public bool $translateURIDashes = false;

    /** Controlador y método que atenderán las rutas no encontradas. */
    public ?string $override404 = null;

    /** Permite buscar controladores cuando ninguna ruta definida coincide. */
    public bool $autoRoute = false;

    /** Activa los atributos que se ejecutan antes y después del controlador. */
    public bool $useControllerAttributes = true;

    /** Permite asignar prioridades a las rutas definidas. */
    public bool $prioritize = false;

    /** Agrupa los segmentos coincidentes de la URL en un único parámetro. */
    public bool $multipleSegmentsOneParam = false;

    /**
     * Relaciona el primer segmento de la URL con el namespace del módulo.
     * @var array<string, string>
     */
    public array $moduleRoutes = [];

    /** Convierte guiones de la URL en CamelCase; prevalece sobre translateURIDashes. */
    public bool $translateUriToCamelCase = true;
}
