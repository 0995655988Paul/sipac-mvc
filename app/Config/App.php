<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    // URL principal; debe terminar en /.
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Dominios adicionales permitidos.
     * @var list<string>
     */
    public array $allowedHostnames = [];

    // Archivo de entrada de la aplicación.
    public string $indexPage = 'index.php';

    // Variable del servidor que contiene la URL.
    public string $uriProtocol = 'REQUEST_URI';

    // Caracteres permitidos en las URLs.
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    // Idioma predeterminado.
    public string $defaultLocale = 'es';

    // Detecta el idioma del navegador.
    public bool $negotiateLocale = false;

    /**
     * Idiomas disponibles, en orden de prioridad.
     * @var list<string>
     */
    public array $supportedLocales = ['es'];

    // Zona horaria de la aplicación.
    public string $appTimezone = 'America/Guayaquil';

    // Codificación de caracteres.
    public string $charset = 'UTF-8';

    // Redirige todas las peticiones a HTTPS.
    public bool $forceGlobalSecureRequests = false;

    /**
     * Proxies de confianza y su cabecera de IP.
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    // Activa las restricciones de origen de contenido (CSP).
    public bool $CSPEnabled = false;
}
