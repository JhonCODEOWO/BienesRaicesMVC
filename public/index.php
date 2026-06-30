<?php

use Controllers\PropiedadController;
use Routes\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();
//Registering routes.
$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedades/create', [PropiedadController::class, 'create']);
$router->post('/propiedades/create', [PropiedadController::class, 'save']);
$router->get('/propiedades/edit/{id}', [PropiedadController::class, 'edit']);

//Handling the incoming request.
$router->checkRoutes();