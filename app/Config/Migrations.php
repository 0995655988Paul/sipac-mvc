<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    // Permite ejecutar migraciones.
    public bool $enabled = true;

    // Tabla con el historial de migraciones.
    public string $table = 'migrations';

    // Formato de fecha para nombrar las migraciones.
    public string $timestampFormat = 'Y-m-d-His_';

    // Evita ejecutar migraciones simultáneas.
    public bool $lock = false;
}
