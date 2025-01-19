<?php

if(!isset($_SESSION['email'])){
    header('Location: ?action=login');
    exit;
}

require_once "../src/models/users/User.php";
require_once "../src/models/users/Users.php";

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'profile';
}


switch ($subAction) {
    case 'profile':
    default:
        $content = '../src/views/profile/profile.php';
        break;
    case 'logout':
        if(session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();

        header('Location: ?#');
        exit;
}

?>