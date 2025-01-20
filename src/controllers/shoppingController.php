<?php

if(!isset($_SESSION['email'])){
    header('Location: ?action=login');
    exit;
}

require_once "../src/models/users/User.php";
require_once "../src/models/users/Users.php";
require_once "../src/models/products/Product.php";
require_once "../src/models/products/ProductsManager.php";
require_once "../src/models/shopping/CartManager.php";

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'carrello';
}


switch ($subAction) {
    case 'carrello':
    default:
        $content = '../src/views/shopping/carrello.php';
        break;
    case 'checkout':
        $user = Users::fromEmail($_SESSION['email']);
        $products = ProductsManager::ListFromUserCart($user->getId());
        if(count($products) == 0){
            $content = '../src/views/shopping/carrello.php';
            $errore = "Non hai nessun prodotto nel carrello";
            break;
        }
        $totalPrice = CartManager::TotalPriceProducts($products);
        $content = '../src/views/shopping/checkout.php';
        break;
}

?>