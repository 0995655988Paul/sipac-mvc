<?php

// Entorno reservado para las pruebas de PHPUnit.

// Muestra todos los errores durante las pruebas.
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Muestra la secuencia de llamadas que originó el error.
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

// Activa la depuración durante las pruebas.
defined('CI_DEBUG') || define('CI_DEBUG', true);
