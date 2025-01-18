<?php

$PRODUCT_TABLE = "prodotto";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['type'])) {
    $id = intval($_POST['id']);  // Ottieni l'ID del prodotto dalla richiesta POST
    $type = strval($_POST['type']);  // Ottieni l'ID del prodotto dalla richiesta POST
    if($type == "cart")
        $type = "carrello";
    
    require_once("../../src/config/connection.php");

    $stmt = Connection::$db->prepare("INSERT INTO `interazione`(`id_prodotto`, `tipo`, `timestamp`) VALUES (?, ?, ?)");
    $date = date('Y-m-d H:i:s');
    $stmt->bind_param("iss", $id, $type, $date);
    $stmt->execute();

    if($stmt->affected_rows == 1){
        echo json_encode([
            'success' => true
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'Inserimento fallito'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida.'
    ]);
}
