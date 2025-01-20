<?php
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../src/config/connection.php");

    // Riceve i dati JSON dalla richiesta
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || empty($input['id'])) {
        $response['status'] = 'error';
        $response['message'] = 'ID prodotto mancante.';
        echo json_encode($response);
        exit;
    }

    $id = intval($input['id']);

    // Query SQL per eliminare il prodotto
    $sql = "DELETE FROM prodotto WHERE id = ?";
    $stmt = Connection::$db->prepare($sql);

    if ($stmt->execute([$id])) {
        $response['status'] = 'success';
        $response['message'] = 'Prodotto eliminato con successo.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Errore durante l\'eliminazione del prodotto.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metodo non valido.';
}

echo json_encode($response);
?>
