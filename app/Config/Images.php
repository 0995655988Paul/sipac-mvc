<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Images\Handlers\GDHandler;
use CodeIgniter\Images\Handlers\ImageMagickHandler;

class Images extends BaseConfig
{
    // Motor de imágenes predeterminado.
    public string $defaultHandler = 'gd';

    /**
     * Ruta antigua de la biblioteca.
     * @deprecated 4.7.0 Sin uso.
     */
    public string $libraryPath = '/usr/local/bin/convert';

    /**
     * Motores disponibles.
     * @var array<string, string>
     */
    public array $handlers = [
        'gd'      => GDHandler::class,
        'imagick' => ImageMagickHandler::class,
    ];
}
