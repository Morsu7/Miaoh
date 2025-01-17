<?php
require_once __DIR__.'/../src/config/config.php';

//Controllo i parametri passati in GET
if (isset($_GET['action'])){
    $action = $_GET['action'];
} else {
    $action = 'home';
}

switch ($action) {
    case 'prova':
        break;
    case 'home':
    default:
        include('../src/controllers/homeController.php');
        break;
        
}

require("../src/views/template/base.php");