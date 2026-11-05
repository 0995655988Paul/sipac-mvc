<?php

namespace Config;

// Opciones de caché; no usar en modo Worker ni con variables de entorno.
class Optimize
{
    /**
     * Caché de configuración.
     * @see https://codeigniter.com/user_guide/concepts/factories.html#config-caching
     */
    public bool $configCacheEnabled = false;

    /**
     * Caché de rutas de archivos.
     * @see https://codeigniter.com/user_guide/concepts/autoloader.html#file-locator-caching
     */
    public bool $locatorCacheEnabled = false;
}
