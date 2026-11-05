<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setAutoRoute(false);
$routes->get('/', 'Home::index', ['filter' => 'csrf']);
$routes->post('login', 'Home::autenticar', ['filter' => 'csrf']);
$routes->get('registro', 'Home::registro', ['filter' => 'csrf']);
$routes->post('registro', 'Home::registrar', ['filter' => 'csrf']);
$routes->post('salir', 'Home::salir', ['filter' => ['auth', 'csrf']]);

$routes->group('', ['filter' => ['auth', 'csrf']], static function (RouteCollection $routes) {
    $routes->get('panel', 'Admin::index');

    $routes->get('productos', 'Productos::index');
    $routes->get('productos/nuevo', 'Productos::nuevo');
    $routes->post('productos/guardar', 'Productos::guardar');
    $routes->get('productos/(:num)/editar', 'Productos::editar/$1');
    $routes->post('productos/(:num)/actualizar', 'Productos::actualizar/$1');
    $routes->post('productos/(:num)/eliminar', 'Productos::eliminar/$1');

    $routes->get('proveedores', 'Proveedores::index');
    $routes->get('proveedores/nuevo', 'Proveedores::nuevo');
    $routes->post('proveedores/guardar', 'Proveedores::guardar');
    $routes->get('proveedores/(:num)/editar', 'Proveedores::editar/$1');
    $routes->post('proveedores/(:num)/actualizar', 'Proveedores::actualizar/$1');

    $routes->get('presupuestos', 'Presupuestos::index');
    $routes->get('presupuestos/nuevo', 'Presupuestos::nuevo');
    $routes->post('presupuestos/guardar', 'Presupuestos::guardar');

    $routes->get('cotizaciones', 'Cotizaciones::index');
    $routes->get('cotizaciones/nueva', 'Cotizaciones::nuevo');
    $routes->post('cotizaciones/guardar', 'Cotizaciones::guardar');

    $routes->get('inventario', 'Inventario::index');
    $routes->post('inventario/movimientos/guardar', 'Inventario::guardarMovimiento');

    $routes->get('planificacion', 'Planificacion::index');
    $routes->get('planificacion/nueva', 'Planificacion::nuevo');
    $routes->post('planificacion/guardar', 'Planificacion::guardar');
    $routes->get('planificacion/(:num)', 'Planificacion::detalle/$1');
    $routes->post('planificacion/(:num)/aprobar', 'Planificacion::aprobar/$1');

    $routes->get('api/productos/(:num)/cotizaciones', 'Api::cotizacionesPorProducto/$1');
});
