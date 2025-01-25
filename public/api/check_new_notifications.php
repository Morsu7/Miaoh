<?php

session_start();

$NOTIFICATIONS_TABLE = "notifica";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/config/connection.php");

        $userId = Users::fromEmail($_SESSION['email'])->getId();
        $query = "
            SELECT *
            FROM " . $NOTIFICATIONS_TABLE . "
            WHERE id_utente = ?
            AND letta = 0";

        $stmt = Connection::$db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            echo json_encode([
                'success' => true,
                'new' => true
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'new' => false
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'No sessione'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida'
    ]);
}
