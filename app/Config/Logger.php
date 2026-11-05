<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Log\Handlers\FileHandler;
use CodeIgniter\Log\Handlers\HandlerInterface;

class Logger extends BaseConfig
{
    /**
     * Nivel de registro: 0 desactiva y 9 registra todo.
     * @var int|list<int>
     */
    public $threshold = (ENVIRONMENT === 'production') ? 4 : 9;

    // Formato de fecha de los registros.
    public string $dateFormat = 'Y-m-d H:i:s';

    /**
     * Destinos del registro, en orden de ejecución.
     * @var array<class-string<HandlerInterface>, array<string, int|list<string>|string>>
     */
    public array $handlers = [
        FileHandler::class => [
            // Niveles que se guardan.
            'handles' => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],

            // Extensión del archivo; vacía usa log.
            'fileExtension' => '',

            // Permisos del archivo en formato octal.
            'filePermissions' => 0644,

            // Carpeta de registros; vacía usa writable/logs.
            'path' => '',
        ],
    ];
}
