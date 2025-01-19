<?php

if(!isset($_SESSION['email'])){
    header('Location: ?action=login');
    exit;
}

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
}

?>