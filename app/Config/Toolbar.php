<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\Toolbar\Collectors\Database;
use CodeIgniter\Debug\Toolbar\Collectors\Events;
use CodeIgniter\Debug\Toolbar\Collectors\Files;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use CodeIgniter\Debug\Toolbar\Collectors\Routes;
use CodeIgniter\Debug\Toolbar\Collectors\Timers;
use CodeIgniter\Debug\Toolbar\Collectors\Views;

/** Configuración de la barra de depuración del framework. */
class Toolbar extends BaseConfig
{
    /**
     * Clases que recopilan los datos de depuración.
     * @var list<class-string>
     */
    public array $collectors = [
        Timers::class,
        Database::class,
        Logs::class,
        Views::class,

        Files::class,
        Routes::class,
        Events::class,
    ];

    /** Recopila las variables enviadas a las vistas. */
    public bool $collectVarData = true;

    /** Límite del historial: 0 lo desactiva y -1 permite entradas ilimitadas. */
    public int $maxHistory = 20;

    /** Ruta absoluta de las vistas de depuración, con barra final. */
    public string $viewsPath = SYSTEMPATH . 'Debug/Toolbar/Views/';

    /** Número máximo de consultas guardadas para depuración. */
    public int $maxQueries = 100;

    /**
     * Carpetas vigiladas para recargar la página, relativas a ROOTPATH.
     * @var list<string>
     */
    public array $watchedDirectories = [
        'app',
    ];

    /**
     * Extensiones vigiladas para recargar la página.
     * @var list<string>
     */
    public array $watchedExtensions = [
        'php', 'css', 'js', 'html', 'svg', 'json', 'env',
    ];

    /**
     * Cabeceras que evitan insertar la barra en respuestas parciales.
     * @var array<string, string|null>
     */
    public array $disableOnHeaders = [
        'X-Requested-With' => 'xmlhttprequest', // Peticiones AJAX
        'HX-Request'       => 'true',           // Peticiones HTMX
        'X-Up-Version'     => null,             // Respuestas parciales de Unpoly
    ];
}
