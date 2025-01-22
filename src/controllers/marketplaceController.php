<?php
include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
require_once('../src/models/products/ProductsManager.php');

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'offerte';
}


switch ($subAction) {
    case 'offerte':
    default:
        $ending_sales = ProductsManager::getEndingSales();
        $offers = ProductsManager::getSales();
        $sales = array_keys($offers);
        $content = '../src/views/marketplace/offerte.php'; 
        break;
}

?>