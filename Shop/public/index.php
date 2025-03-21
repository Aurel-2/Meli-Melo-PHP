<?php
session_start();

use controllers\LoginController;
use controllers\ProductController;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/LoginController.php';
require_once __DIR__ . '/../models/Product.php';

$controller = new ProductController();
$loginController = new LoginController();
$products = $controller->read() ?? [];

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $loginController->logout();
}
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$allowedActions = ['index', 'api-get', 'create', 'update', 'delete', 'login', 'logout'];

if (!in_array($action, $allowedActions)) {
    $action = 'index';
}

switch ($action) {
    case 'index':
        $products = $controller->read();
        include __DIR__ . '/../views/shopView.php';
        break;
    case 'api-get':
        $controller->api_get_products();
        break;
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'login':
        $loginController->login($_POST['username'], $_POST['password']);
        include __DIR__ . '/../views/shopView.php';
        break;

}