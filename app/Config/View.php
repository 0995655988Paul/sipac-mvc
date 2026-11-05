<?php

namespace Config;

use CodeIgniter\Config\View as BaseView;
use CodeIgniter\View\ViewDecoratorInterface;

class View extends BaseView
{
    /**
     * Conserva los datos entre llamadas a las vistas cuando está activado.
     * @var bool
     */
    public $saveData = true;

    /**
     * Funciones permitidas para filtrar variables del parser de vistas.
     * @var array<string, (callable(mixed): mixed)&string>
     */
    public $filters = [];

    /**
     * Alias de funciones que amplían el parser de vistas.
     * @var array<string, (callable(mixed...): mixed)|((callable(mixed...): mixed)&string)|list<(callable(mixed...): mixed)&string>>
     */
    public $plugins = [];

    /**
     * Clases que modifican la salida de las vistas antes de guardarla en caché.
     * @var list<class-string<ViewDecoratorInterface>>
     */
    public array $decorators = [];

    /** Subcarpeta de app/Views para sustituir vistas de paquetes o módulos. */
    public string $appOverridesFolder = 'overrides';
}
