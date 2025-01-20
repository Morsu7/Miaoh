<?php

session_start();

$CART_TABLE = "carrello";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/config/connection.php");
        $user = Users::fromEmail($_SESSION['email']);
        $userId = $user->getId();

        echo json_encode([
            'success' => false,
            'error' => 'Boia deh'
        ]);

        /*$stmt = Connection::$db->prepare("
            INSERT INTO " . $CART_TABLE . " (id_utente, id_prodotto, quantita)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE quantita = VALUES(quantita);
        ");
        $stmt->bind_param("iii", $userId, $id, $quantity);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            echo json_encode([
                'success' => true
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'error' => 'Inserimento non necessario o fallito'
            ]);
        }*/
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'No sessione'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida.'
    ]);
}
