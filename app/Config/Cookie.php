<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use DateTimeInterface;

class Cookie extends BaseConfig
{
    // Prefijo de los nombres de cookies.
    public string $prefix = '';

    /**
     * Caducidad de la cookie; 0 dura hasta cerrar la sesión del navegador.
     * @var DateTimeInterface|int|string
     */
    public $expires = 0;

    // Ruta donde se permite la cookie.
    public string $path = '/';

    // Dominio de la cookie.
    public string $domain = '';

    // Envía la cookie solo mediante HTTPS.
    public bool $secure = false;

    // Impide que JavaScript lea la cookie.
    public bool $httponly = true;

    /**
     * Controla el envío entre sitios; None requiere secure.
     * @var ''|'Lax'|'None'|'Strict'
     */
    public string $samesite = 'Lax';

    // Guarda nombre y valor sin codificar la URL.
    public bool $raw = false;
}
