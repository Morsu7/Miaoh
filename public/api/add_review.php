<?php

session_start();

require_once("../../src/models/users/User.php");
require_once("../../src/models/users/Users.php");
require_once("../../src/config/connection.php");

if(isset($_SESSION['email'])){
    $product_id = $_POST['idProduct'] ?? null;
    $valutazione = $_POST['rating'] ?? null;
    $descrizione = $_POST['description'] ?? null;
    $utente = Users::fromEmail($_SESSION['email'])->getId();

    if ($product_id && $valutazione && $descrizione) {
        $stmt = Connection::$db->prepare("
            SELECT * FROM recensione
            WHERE utente = ? AND prodotto_id = ?;
        ");
        $stmt->bind_param("ii", $utente, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1){
            // L'utente ha già il prodotto nel carrello, incremento la quantità di 1
            $stmt = Connection::$db->prepare("
                UPDATE recensione
                SET descrizione = ?, valutazione = ?
                WHERE utente = ? AND prodotto_id = ?;
            ");
            $stmt->bind_param("siii",$descrizione,$valutazione,$utente, $product_id);
            $stmt->execute();
        }else{
            // L'utente non ha il prodotto nel carrello, lo aggiungo
            $stmt = Connection::$db->prepare("
                INSERT INTO recensione (utente, prodotto_id, valutazione, descrizione)
                VALUES (?, ?, ?, ?);
            ");
            $stmt->bind_param("iiis", $utente, $product_id, $valutazione, $descrizione);
            $stmt->execute();
        }

        if($stmt->affected_rows > 0){
            echo json_encode([
                'success' => true
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'error' => $stmt->error
            ]);
        }
    } else {
        echo json_encode(['success' => false,
        'error' => 'dati non validi']);
    }
}else{
    echo json_encode([
        'success' => false,
        'error' => 'No sessione'
    ]);
}
