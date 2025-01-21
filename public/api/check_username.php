<?php

$USER_TABLE = "user";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    
    require_once("../../src/config/connection.php");

    $stmt = Connection::$db->prepare("SELECT * FROM $USER_TABLE WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        echo json_encode([
            'success' => true
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'Username occupato'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida.'
    ]);
}
