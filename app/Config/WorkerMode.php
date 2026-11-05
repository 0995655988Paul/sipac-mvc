<?php

namespace Config;

/** Configuración del modo worker de FrankenPHP. */
class WorkerMode
{
    /**
     * Servicios que conservan su estado entre peticiones; los demás se reinician.
     * @var list<string>
     */
    public array $persistentServices = [
        'autoloader',
        'locator',
        'exceptions',
        'commands',
        'codeigniter',
        'superglobals',
        'routes',
        'cache',
    ];

    /**
     * Eventos cuyos listeners se eliminan entre peticiones para evitar duplicados.
     * @var list<string>
     */
    public array $resetEventListeners = [];

    /** Libera memoria después de cada petición. */
    public bool $forceGarbageCollection = true;
}
