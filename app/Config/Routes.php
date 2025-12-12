<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Basic Defaults
$routes->get('/', 'AuthController::login');
$routes->get('/dashboard', 'Home::index');

// Auth
$routes->post('authenticate', 'AuthController::authenticate');
$routes->get('register', 'AuthController::register');
$routes->post('register/store', 'AuthController::store');
$routes->get('logout', 'AuthController::logout');
$routes->post('login', 'AuthController::login'); // Keep for post if needed or just use authenticate

// Functional Requirements Specific Routes
// RF-11 & RF-12: Vehicle Status and History
$routes->get('vehiculos/status/(:num)', 'Vehiculos::status/$1');
$routes->get('vehiculos/history/(:num)', 'Vehiculos::history/$1');
$routes->get('historial/(:num)', 'Historial::show/$1');

// RF-04: Walk-in Registration
$routes->get('vehiculos/recepcion', 'Recepcion::index');
$routes->post('vehiculos/recepcion/store', 'Recepcion::store');

// RF-13: Cancel Reservation
$routes->post('reservas/cancel/(:num)', 'Reservas::cancel/$1');

// RF-05 & RF-06: Work Orders Assignment and Completion
$routes->get('ordenestrabajo/assign/(:num)', 'OrdenesTrabajo::assign/$1');
$routes->post('ordenestrabajo/store', 'OrdenesTrabajo::store');
$routes->get('ordenestrabajo/complete/(:num)', 'OrdenesTrabajo::complete/$1');
$routes->post('ordenestrabajo/finalize', 'OrdenesTrabajo::finalize');

// RF-09 & RF-10: Invoices
$routes->post('facturas/generate/(:num)', 'Facturas::generate/$1'); // parameter is id_orden
$routes->post('facturas/pay/(:num)', 'Facturas::pay/$1');

// Standard REST Resources
$routes->resource('usuarios');
$routes->resource('clientes');
$routes->resource('empleados');
$routes->resource('vehiculos');
$routes->resource('servicios');
$routes->resource('insumos');
$routes->resource('reservas');
$routes->resource('detallereserva');
$routes->resource('ordenestrabajo');
$routes->resource('facturas');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
