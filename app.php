<?php
session_start();

include_once 'controllers/UsersController.php';
include_once 'controllers/ProdukController.php';
include_once 'controllers/KategoriController.php';
include_once 'controllers/PesananController.php';
include_once 'config/database.php';
include_once 'middleware/Router.php';

$database = new Database();
$db = $database->getConnection();

$usersController = new UsersController($db);
$produkController = new ProdukController($db);
$kategoriController = new KategoriController($db);
$pesananController = new PesananController($db);

// Set up the router
$router = new Router();

// Login route
$router->register('POST', '/api/login', function() use ($usersController) {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $password = $data['password'];
    
    if ($usersController->login($username, $password)) {
        echo json_encode(array("message" => "Login successful"));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid username or password"));
    }
    exit();
});

// Logout route
$router->register('POST', '/api/logout', function() use ($usersController) {
    if ($usersController->logout()) {
        echo json_encode(array("message" => "Logout successful"));
    } else {
        echo json_encode(array("message" => "Logout failed"));
    }
    exit();
});

// User routes
$router->register('GET', '/api/users', [$usersController, 'readUsers']);
$router->register('GET', '/api/users/id/{id}', function($params) use ($usersController) {
    return $usersController->readUserById($params['id']);
});
$router->register('GET', '/api/users/username/{username}', function($params) use ($usersController) {
    return $usersController->readUserByUsername($params['username']);
});
$router->register('GET', '/api/users/role/{role}', function($params) use ($usersController) {
    return $usersController->readUsersByRole($params['role']);
});
$router->register('POST', '/api/users', [$usersController, 'addUsers']);
$router->register('PUT', '/api/users', [$usersController, 'updateUsers']);
$router->register('DELETE', '/api/users', [$usersController, 'deleteUsers']);

// Produk routes
$router->register('GET', '/api/produk', [$produkController, 'readProduk']);
$router->register('GET', '/api/produk/id/{id}', function($params) use ($produkController) {
    return $produkController->readProdukById($params['id']);
});
$router->register('POST', '/api/produk', [$produkController, 'addProduk']);
$router->register('PUT', '/api/produk', [$produkController, 'updateProduk']);
$router->register('DELETE', '/api/produk', [$produkController, 'deleteProduk']);

// Kategori routes
$router->register('GET', '/api/kategori', [$kategoriController, 'readKategori']);
$router->register('GET', '/api/kategori/id/{id}', function($params) use ($kategoriController) {
    return $kategoriController->readKategoriById($params['id']);
});
$router->register('POST', '/api/kategori', [$kategoriController, 'addKategori']);
$router->register('PUT', '/api/kategori', [$kategoriController, 'updateKategori']);
$router->register('DELETE', '/api/kategori', [$kategoriController, 'deleteKategori']);

// Pesanan routes
$router->register('GET', '/api/pesanan', [$pesananController, 'readPesanan']);
$router->register('GET', '/api/pesanan/id/{id}', function($params) use ($pesananController) {
    return $pesananController->readPesananById($params['id']);
});
$router->register('POST', '/api/pesanan', [$pesananController, 'addPesanan']);
$router->register('PUT', '/api/pesanan', [$pesananController, 'updatePesanan']);
$router->register('DELETE', '/api/pesanan', [$pesananController, 'deletePesanan']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>