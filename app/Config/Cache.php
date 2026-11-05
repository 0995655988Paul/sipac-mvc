<?php

namespace Config;

use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\Cache\Handlers\ApcuHandler;
use CodeIgniter\Cache\Handlers\DummyHandler;
use CodeIgniter\Cache\Handlers\FileHandler;
use CodeIgniter\Cache\Handlers\MemcachedHandler;
use CodeIgniter\Cache\Handlers\PredisHandler;
use CodeIgniter\Cache\Handlers\RedisHandler;
use CodeIgniter\Cache\Handlers\WincacheHandler;
use CodeIgniter\Config\BaseConfig;

class Cache extends BaseConfig
{
    // Gestor principal de caché.
    public string $handler = 'file';

    // Gestor alternativo si el principal falla.
    public string $backupHandler = 'dummy';

    // Prefijo para evitar claves repetidas.
    public string $prefix = '';

    // Duración predeterminada de la caché, en segundos.
    public int $ttl = 60;

    // Caracteres prohibidos en las claves.
    public string $reservedCharacters = '{}()/\@:';

    /**
     * Opciones de caché en archivos.
     * @var array{storePath?: string, mode?: int}
     */
    public array $file = [
        'storePath' => WRITEPATH . 'cache/',
        'mode'      => 0640,
    ];

    /**
     * Conexión a Memcached.
     * @var array{host?: string, port?: int, weight?: int, raw?: bool}
     */
    public array $memcached = [
        'host'   => '127.0.0.1',
        'port'   => 11211,
        'weight' => 1,
        'raw'    => false,
    ];

    /**
     * Conexión a Redis.
     * @var array{ host?: string, password?: string|null, port?: int, timeout?: int, async?: bool, persistent?: bool, database?: int }
     */
    public array $redis = [
        'host'       => '127.0.0.1',
        'password'   => null,
        'port'       => 6379,
        'timeout'    => 0,
        'async'      => false, // Solo para Predis.
        'persistent' => false,
        'database'   => 0,
    ];

    /**
     * Gestores de caché disponibles.
     * @var array<string, class-string<CacheInterface>>
     */
    public array $validHandlers = [
        'apcu'      => ApcuHandler::class,
        'dummy'     => DummyHandler::class,
        'file'      => FileHandler::class,
        'memcached' => MemcachedHandler::class,
        'predis'    => PredisHandler::class,
        'redis'     => RedisHandler::class,
        'wincache'  => WincacheHandler::class,
    ];

    /**
     * Incluye los parámetros de la URL en la clave de caché.
     * @var bool|list<string>
     */
    public $cacheQueryString = false;

    /**
     * Estados HTTP almacenables; vacío permite todos.
     * @var list<int>
     */
    public array $cacheStatusCodes = [];
}
