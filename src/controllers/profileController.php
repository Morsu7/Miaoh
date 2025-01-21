<?php

if(!isset($_SESSION['email'])){
    header('Location: ?action=login');
    exit;
}

require_once "../src/models/users/User.php";
require_once "../src/models/users/Users.php";
require_once "../src/models/images/ImageManager.php";

$user = Users::fromEmail($_SESSION['email']);
$picture = $picture = ImageManager::getUserImagePath($_SESSION['email']);

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'profile';
}

switch ($subAction) {
    case 'profile':
    case 'orders':
    default:
        $profile_details = '../src/views/profile/profile_details.php';
        $orders = '../src/views/profile/orders.php';
        $notifications_view = '../src/views/profile/notifications.php';

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