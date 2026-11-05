<?php

// Muestra todos los errores durante el desarrollo.
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Muestra la secuencia de llamadas que originó el error.
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

// Activa las herramientas de depuración.
defined('CI_DEBUG') || define('CI_DEBUG', true);
