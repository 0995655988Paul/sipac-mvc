<?php

// Oculta los detalles de los errores en producción.
error_reporting(E_ALL & ~E_DEPRECATED);

ini_set('display_errors', '0');

// Desactiva las herramientas de depuración en producción.
defined('CI_DEBUG') || define('CI_DEBUG', false);
