<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\ExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use Psr\Log\LogLevel;
use Throwable;

// Configuración del manejo de errores.
class Exceptions extends BaseConfig
{
    // Registra las excepciones en el archivo de errores.
    public bool $log = true;

    /**
     * Estados HTTP que no se registran.
     * @var list<int>
     */
    public array $ignoreCodes = [404];

    // Carpeta de las vistas de error.
    public string $errorViewPath = APPPATH . 'Views/errors';

    /**
     * Datos que se ocultan al depurar.
     * @var list<string>
     */
    public array $sensitiveDataInTrace = [];

    // Registra avisos de funciones obsoletas sin lanzar excepciones.
    public bool $logDeprecations = true;

    // Nivel de registro de los avisos de funciones obsoletas.
    public string $deprecationLogLevel = LogLevel::WARNING;

    // Selecciona el gestor que muestra cada error.
    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        return new ExceptionHandler($this);
    }
}
