<?php
// delete_review.php

// Include database connection
require_once("../../src/config/connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $idProduct = isset($_POST['idProduct']) ? $_POST['idProduct'] : null;
    $idUtente = isset($_POST['idUtente']) ? $_POST['idUtente'] : null;


    // Check if both idProduct and idUtente are provided
    if ($idProduct && $idUtente) {
        $stmt = Connection::$db->prepare("
            DELETE FROM recensione
            WHERE prodotto_id = ? AND utente = ?
        ");
        
        $stmt->bind_param('ii', $idProduct, $idUtente);

        // Execute the statement
        if ($stmt->execute()) {
            // Check if any row was affected
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true];
            } else {
                $response = ['success' => false, 'error' => 'Nessuna recensione trovata per eliminare.'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Errore durante l\'eliminazione della recensione.'];
        }

        // Close the statement
        $stmt->close();
    } else {
        $response = ['success' => false, 'error' => 'Dati mancanti.'];
    }
} else {
    $response = ['success' => false, 'error' => 'Metodo di richiesta non valido.'];
}

// Set the content type to JSON and output the response
header('Content-Type: application/json');
echo json_encode($response);
?>