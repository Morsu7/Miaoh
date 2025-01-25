<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin'])) {
    require_once("../../../src/config/connection.php");
    $id_acquisto = $_POST['id_acquisto'] ?? null;
    $stato_acquisto = $_POST['stato_acquisto'] ?? null;

    if ($id_acquisto && in_array($stato_acquisto, ['da_spedire', 'spedito', 'consegnato'])) {
        $stmt = Connection::$db->prepare("
            UPDATE acquisti
            SET stato_acquisto = ?
            WHERE id_acquisto = ?
        ");
        $stmt->bind_param("si", $stato_acquisto, $id_acquisto);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response['message'] = "Stato dell'ordine aggiornato con successo.";
            $response['id_acquisto'] = $id_acquisto;
            $response['stato_acquisto'] = $stato_acquisto;
            $response['success'] = true;
        }
    } else {
        $response['message'] = 'Dati non validi.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>