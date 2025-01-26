<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0") {
    require_once("../../../src/models/notifications/NotificationManager.php");
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

            $stmt = Connection::$db->prepare("SELECT id_utente FROM acquisti WHERE id_acquisto = ?");
            $stmt->bind_param("i", $id_acquisto);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $userId = $row['id_utente'];

            switch($stato_acquisto){
                case 'spedito':
                    NotificationManager::notificaOrdineSpedito($userId, $id_acquisto);
                    break;
                case 'consegnato':
                    NotificationManager::notificaOrdineConsegnato($userId, $id_acquisto);
                    break;
            }
        } else {
            $response['message'] = 'Errore durante l\'aggiornamento dello stato dell\'ordine.';
        }
    } else {
        $response['message'] = 'Dati non validi.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>