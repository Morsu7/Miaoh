<?php
include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
require_once('../src/models/products/ProductsManager.php');
require_once('../src/models/images/ImageManager.php');

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'detail';
}


switch ($subAction) {
    case 'detail':
    default:
        $product = ProductsManager::fromId($_POST['product_id']);
        $products = ProductsManager::getRelatedProducts($product->getTipoProdottoId(), 10);
        $content = '../src/views/product/detail.php';
        break;
}

?>