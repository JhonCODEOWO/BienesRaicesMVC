<?php

use Controllers\BlogController;
use Controllers\LoginController;
use Controllers\PropiedadController;
use Controllers\PublicController;
use Controllers\TestingController;
use Controllers\VendedoresController;
use Middlewares\AuthMiddleware;
use Routes\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();
//Registering routes.
$router->get('/testing', [TestingController::class, 'testing']);

$router->get('/admin', [PropiedadController::class, 'index'], [AuthMiddleware::class]);
$router->get('/propiedades/create', [PropiedadController::class, 'create'], [AuthMiddleware::class]);
$router->post('/propiedades/create', [PropiedadController::class, 'save'], [AuthMiddleware::class]);
$router->get('/propiedades/edit/{id}', [PropiedadController::class, 'edit', [AuthMiddleware::class]]);
$router->post('/propiedades/update/{id}', [PropiedadController::class, 'update', [AuthMiddleware::class]]);
$router->post('/propiedades/delete/{id}', [PropiedadController::class, 'delete', [AuthMiddleware::class]]);

$router->get('/vendedores/create', [VendedoresController::class, 'create'], [AuthMiddleware::class]);
$router->post('/vendedores/create', [VendedoresController::class, 'store'], [AuthMiddleware::class]);
$router->get('/vendedores/edit/{id}', [VendedoresController::class, 'edit', [AuthMiddleware::class]]);
$router->post('/vendedores/update/{id}', [VendedoresController::class, 'update'], [AuthMiddleware::class]);
$router->post('/vendedores/delete/{id}', [VendedoresController::class, 'delete'], [AuthMiddleware::class]);

$router->get('/', [PublicController::class, 'index']);
$router->get('/about', [PublicController::class, 'about']);
$router->get('/propiedades', [PublicController::class, 'propiedades']);
$router->get('/propiedad/{id}', [PublicController::class, 'propiedad']);
$router->get('/contactUs', [PublicController::class, 'contactUs']);
$router->post('/contactUs', [PublicController::class, 'contactingUs']);

$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/entry', [BlogController::class, 'blogEntry']);

$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'authenticate']);
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'createAccount']);
$router->post('/logout', [LoginController::class, 'logout']);

//Handling the incoming request.
$router->checkRoutes();