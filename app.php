<?php
include_once 'controllers/UsersController.php';
include_once 'controllers/ProdukController.php';
include_once 'config/database.php';
include_once 'middleware/Router.php';

$database = new Database();
$db = $database->getConnection();
$usersController = new UsersController($db);

// Set up the router
$router = new Router();

// User routes
$router->register('GET', '/api/users', [$usersController, 'readUsers']);
$router->register('POST', '/api/users', [$usersController, 'addUsers']);
$router->register('PUT', '/api/users', [$usersController, 'updateUsers']);
$router->register('DELETE', '/api/users', [$usersController, 'deleteUsers']);

// Produk routes
$router->register('GET', '/api/produk', [$produkController, 'readProduk']);
$router->register('POST', '/api/produk', [$produkController, 'addProduk']);
$router->register('PUT', '/api/produk', [$produkController, 'updateProduk']);
$router->register('DELETE', '/api/produk', [$produkController, 'deleteProduk']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>
