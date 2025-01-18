<?php
include('../src/models/Product.php');
include('../src/models/Products.php');

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'home';
}


switch ($subAction) {
    case 'home':
    default:
        $productsManager = new Products();
        $allProducts = $productsManager->getAllProducts();
        $content = '../src/views/home/home.php';
        break;
}

?>