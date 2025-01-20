<?php

include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
require_once('../src/models/products/ProductsManager.php');

// TODO: Controllare se l'utente è admin

if(!isset($_SESSION['email'])){
    header('Location: ?action=login');
    exit;
}

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'dashboard';
}

$show_header = false;

switch ($subAction) {
    case 'dashboard':
    default:
        $content = '../src/views/admin/dashboard.php';
        break;
    case 'products':
        $allProducts = ProductsManager::getAllProducts();
        $content = '../src/views/admin/products.php';
        break;
    case 'homepage':
        header('Location: ?#');
        exit;
}

?>