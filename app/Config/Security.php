<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Security extends BaseConfig
{
    /**
     * Método de protección CSRF.
     * @var string 'cookie' or 'session'
     */
    public string $csrfProtection = 'cookie';

    /** Aleatoriza la representación del token CSRF. */
    public bool $tokenRandomize = false;

    /** Nombre del campo que contiene el token CSRF. */
    public string $tokenName = 'csrf_test_name';

    /** Nombre de la cabecera HTTP para el token CSRF. */
    public string $headerName = 'X-CSRF-TOKEN';

    /** Nombre de la cookie del token CSRF. */
    public string $cookieName = 'csrf_cookie_name';

    /** Duración de la cookie CSRF en segundos. */
    public int $expires = 7200;

    /** Renueva el token CSRF después de cada envío. */
    public bool $regenerate = true;

    /**
     * Redirige a la página anterior si falla la protección CSRF.
     * @see https://codeigniter4.github.io/userguide/libraries/security.html#redirection-on-failure
     */
    public bool $redirect = (ENVIRONMENT === 'production');
}
