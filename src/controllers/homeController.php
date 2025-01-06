<?php

namespace src\controllers;

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'home';
}


switch ($subAction) {
    case 'home':
    default:
        $content = '../src/views/home/home.php';
        break;
}

?>