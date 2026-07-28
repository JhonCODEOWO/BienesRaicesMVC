<?php

use Controllers\BlogController;
use Controllers\PropiedadController;
use Controllers\PublicController;
use Controllers\VendedoresController;

use Routes\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();
//Registering routes.
$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedades/create', [PropiedadController::class, 'create']);
$router->post('/propiedades/create', [PropiedadController::class, 'save']);
$router->get('/propiedades/edit/{id}', [PropiedadController::class, 'edit']);
$router->post('/propiedades/update/{id}', [PropiedadController::class, 'update']);
$router->post('/propiedades/delete/{id}', [PropiedadController::class, 'delete']);

$router->get('/vendedores/create', [VendedoresController::class, 'create']);
$router->post('/vendedores/create', [VendedoresController::class, 'store']);
$router->get('/vendedores/edit/{id}', [VendedoresController::class, 'edit']);
$router->post('/vendedores/update/{id}', [VendedoresController::class, 'update']);
$router->post('/vendedores/delete/{id}', [VendedoresController::class, 'delete']);

$router->get('/', [PublicController::class, 'index']);
$router->get('/about', [PublicController::class, 'about']);
$router->get('/propiedades', [PublicController::class, 'propiedades']);
$router->get('/propiedad/{id}', [PublicController::class, 'propiedad']);
$router->get('/contactUs', [PublicController::class, 'contactUs']);
$router->post('/contactUs', [PublicController::class, 'contactingUs']);

$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/entry', [BlogController::class, 'blogEntry']);

//Handling the incoming request.
$router->checkRoutes();