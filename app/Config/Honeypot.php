<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Honeypot extends BaseConfig
{
    // Oculta a las personas el campo que detecta bots.
    public bool $hidden = true;

    // Etiqueta del campo para detectar bots.
    public string $label = 'Fill This Field';

    // Nombre del campo para detectar bots.
    public string $name = 'honeypot';

    // Plantilla HTML del campo.
    public string $template = '<label>{label}</label><input type="text" name="{name}" value="">';

    // Contenedor HTML del campo.
    public string $container = '<div style="display:none">{template}</div>';

    // Identificador del contenedor para usar CSP.
    public string $containerId = 'hpc';
}
