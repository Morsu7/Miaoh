<?php

session_start();

$CART_TABLE = "carrello";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = intval($_POST['id']);  // Ottieni l'ID del prodotto dalla richiesta POST

    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/config/connection.php");
        $user = Users::fromEmail($_SESSION['email']);
        $userId = $user->getId();

        $stmt = Connection::$db->prepare("
            DELETE FROM " . $CART_TABLE . "
            WHERE id_utente = ? AND id_prodotto = ?;
        ");
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            echo json_encode([
                'success' => true
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'error' => 'Rimozione non necessaria o fallito'
            ]);
        }
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
