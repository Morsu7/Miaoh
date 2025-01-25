<?php

include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
include('../src/models/products/Category.php');
include('../src/models/orders/Order.php');
require_once('../src/models/products/ProductsManager.php');
require_once('../src/models/orders/OrdersManager.php');

if(!isset($_SESSION['isAdmin'])){
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
        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }

        $productsPerPage = 20;
        $allProducts = ProductsManager::fetchProductsByPage($currentPage, $productsPerPage);
        $totalPages = ceil(ProductsManager::getProductsNumber() / $productsPerPage);
        $categories = ProductsManager::getCategories();
        $content = '../src/views/admin/products.php';
        break;
    case 'orders':
        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }

        $ordersPerPage = 20;
        $allOrders = OrdersManager::fetchOrdersByPage($currentPage, $ordersPerPage);
        $totalPages = ceil(OrdersManager::getOrdersNumber() / $ordersPerPage);

        $content = '../src/views/admin/orders.php';
        break;
    case 'homepage':
        header('Location: ?#');
        exit;
}

?>