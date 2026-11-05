<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Permisos para peticiones desde otros sitios (CORS).
class Cors extends BaseConfig
{
    /**
     * Permisos CORS predeterminados.
     * @var array{ allowedOrigins: list<string>, allowedOriginsPatterns: list<string>, supportsCredentials: bool, allowedHeaders: list<string>, exposedHeaders: list<string>, allowedMethods: list<string>, maxAge: int, }
     */
    public array $default = [
        // Orígenes permitidos.
        'allowedOrigins' => [],

        // Patrones de los orígenes permitidos.
        'allowedOriginsPatterns' => [],

        // Permite credenciales en peticiones entre sitios.
        'supportsCredentials' => false,

        // Cabeceras permitidas en peticiones.
        'allowedHeaders' => [],

        // Cabeceras que puede leer JavaScript.
        'exposedHeaders' => [],

        // Métodos HTTP permitidos.
        'allowedMethods' => [],

        // Duración de los permisos en caché, en segundos.
        'maxAge' => 7200,
    ];
}
