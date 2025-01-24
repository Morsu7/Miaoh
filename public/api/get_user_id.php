<?php
require_once("../../src/models/users/User.php");
require_once("../../src/models/users/Users.php");
require_once("../../src/config/connection.php");

session_start();
if (isset($_SESSION['email'])) {
    $user = Users::fromEmail($_SESSION['email']);
    if ($user) {
        echo json_encode(['success' => true, 'userId' => $user->getId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No email in session']);
}
?>