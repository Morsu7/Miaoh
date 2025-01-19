<?php
include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
require_once('../src/models/products/ProductsManager.php');

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'home';
}


switch ($subAction) {
    case 'home':
    default:
        //$productsManager = new Products();
        //$allProducts = $productsManager->getAllProducts();
        $trending_products = ProductsManager::getTrendingProducts(8);
        $products = ProductsManager::getRandomProducts(20);
        $content = '../src/views/home/home.php';
        break;
}

?>