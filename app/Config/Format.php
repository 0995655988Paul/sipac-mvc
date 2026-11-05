<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Format\JSONFormatter;
use CodeIgniter\Format\XMLFormatter;

class Format extends BaseConfig
{
    /**
     * Formatos de respuesta disponibles.
     * @var list<string>
     */
    public array $supportedResponseFormats = [
        'application/json',
        'application/xml', // XML para procesar datos.
        'text/xml', // XML de texto.
    ];

    /**
     * Clase que genera cada formato de respuesta.
     * @var array<string, string>
     */
    public array $formatters = [
        'application/json' => JSONFormatter::class,
        'application/xml'  => XMLFormatter::class,
        'text/xml'         => XMLFormatter::class,
    ];

    /**
     * Opciones de los formatos de respuesta.
     * @var array<string, int>
     */
    public array $formatterOptions = [
        'application/json' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        'application/xml'  => 0,
        'text/xml'         => 0,
    ];

    // Profundidad máxima al generar JSON.
    public int $jsonEncodeDepth = 512;
}
