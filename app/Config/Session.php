<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\BaseHandler;
use CodeIgniter\Session\Handlers\FileHandler;

class Session extends BaseConfig
{
    /**
     * Manejador que almacena las sesiones.
     * @var class-string<BaseHandler>
     */
    public string $driver = FileHandler::class;

    /** Nombre de la cookie de sesión; admite letras minúsculas, números, guion y guion bajo. */
    public string $cookieName = 'ci_session';

    /** Duración de la sesión en segundos; 0 indica que termina al cerrar el navegador. */
    public int $expiration = 7200;

    /** Destino de las sesiones: carpeta absoluta para archivos o tabla para base de datos. */
    public string $savePath = WRITEPATH . 'session';

    /** Comprueba que la IP coincida al leer la sesión. */
    public bool $matchIP = false;

    /** Intervalo en segundos para renovar el identificador de sesión. */
    public int $timeToUpdate = 300;

    /** Elimina los datos del identificador anterior al renovar la sesión. */
    public bool $regenerateDestroy = false;

    /** Grupo de conexión para las sesiones almacenadas en base de datos. */
    public ?string $DBGroup = null;

    /** Espera entre intentos de bloqueo de Redis, en microsegundos. */
    public int $lockRetryInterval = 100_000;

    /** Número máximo de intentos de bloqueo de Redis. */
    public int $lockMaxRetries = 300;
}
