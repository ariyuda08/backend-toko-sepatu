<?php
include_once 'controllers/UsersController.php';
include_once 'config/database.php';
include_once 'middleware/Router.php';

$database = new Database();
$db = $database->getConnection();
$usersController = new UsersController($db);

// Set up the router
$router = new Router();
$router->register('GET', '/api/users', [$usersController, 'readUsers']);
$router->register('POST', '/api/users', [$usersController, 'addUser']);

//Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));