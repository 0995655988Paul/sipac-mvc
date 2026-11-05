<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Opciones de compatibilidad del framework.
class Feature extends BaseConfig
{
    // Usa el enrutamiento automático actualizado.
    public bool $autoRoutesImproved = true;

    // Usa el orden de filtros anterior a la versión 4.5.
    public bool $oldFilterOrder = false;

    // Si es true, limit(0) devuelve todos los registros.
    public bool $limitZeroAsAll = true;

    // Exige coincidencia exacta de idioma y región.
    public bool $strictLocaleNegotiation = false;
}
