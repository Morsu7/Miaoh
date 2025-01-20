<?php
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    unset($input['id']); // Rimuove l'ID dai dati da aggiornare

    // Costruisce dinamicamente la query SQL
    $columns = [];
    $values = [];

    foreach ($input as $key => $value) {
        $columns[] = "$key = ?";
        $values[] = htmlspecialchars($value); // Sanificazione
    }

    if (count($columns) > 0) {
        $sql = "UPDATE prodotto SET " . implode(', ', $columns) . " WHERE id = ?";
        $values[] = $id;

        $stmt = Connection::$db->prepare($sql);

        if ($stmt->execute($values)) {
            $response['status'] = 'success';
            $response['message'] = 'Prodotto aggiornato con successo.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Errore durante l\'aggiornamento del prodotto.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Nessun dato da aggiornare.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>