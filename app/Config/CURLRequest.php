<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CURLRequest extends BaseConfig
{
    /**
     * Datos de conexión compartidos entre peticiones.
     * @var list<int>
     */
    public array $shareConnectionOptions = [
        CURL_LOCK_DATA_CONNECT,
        CURL_LOCK_DATA_DNS,
    ];

    // Reutiliza las opciones entre peticiones; puede conservar sus datos.
    public bool $shareOptions = false;
}
