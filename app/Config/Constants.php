<?php

// Espacio de nombres de la aplicación.
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

// Ruta del cargador de Composer.
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

// Duraciones expresadas en segundos.
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

// Códigos de salida del programa.
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // Sin errores.
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // Error general.
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // Error de configuración.
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // Archivo no encontrado.
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // Clase desconocida.
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // Método desconocido.
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // Entrada inválida.
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // Error de base de datos.
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // Código automático mínimo.
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // Código automático máximo.
