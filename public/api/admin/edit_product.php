<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin'])) {
    require_once("../../../src/config/connection.php");

    // Verifica se un file è stato caricato
    $uploadedImage = isset($_FILES['img1']) && $_FILES['img1']['error'] === UPLOAD_ERR_OK;

    // Dati che possono essere aggiornati
    $fields = [
        'nome' => FILTER_SANITIZE_STRING,
        'descrizione' => FILTER_SANITIZE_STRING,
        'quantita' => FILTER_VALIDATE_INT,
        'prezzo' => FILTER_VALIDATE_FLOAT,
        'sconto' => FILTER_VALIDATE_FLOAT,
        'fineSconto' => FILTER_SANITIZE_STRING, // Assume che il formato sia una stringa valida
        'tipoProdottoId' => FILTER_VALIDATE_INT,
    ];

    // Prepara i dati in arrivo
    $input = filter_input_array(INPUT_POST, $fields);
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if (!$id) {
        $response['message'] = 'ID prodotto mancante.';
        echo json_encode($response);
        exit;
    }

    // Inizializza colonne e valori per la query
    $columns = [];
    $values = [];

    foreach ($input as $key => $value) {
        if ($value !== null && $value !== false) { // Valida i campi non nulli o non falsi
            $columns[] = "$key = ?";
            $values[] = $value;
        }
    }

    // Gestione dell'immagine caricata
    if ($uploadedImage) {
        $imagePath = '../../../uploads/' . basename($_FILES['img1']['name']);
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $imagePath)) {
            $columns[] = "img1 = ?";
            $values[] = $imagePath;
        } else {
            $response['message'] = 'Errore durante il caricamento dell\'immagine.';
            echo json_encode($response);
            exit;
        }
    }

    if (count($columns) > 0) {
        $sql = "UPDATE prodotto SET " . implode(', ', $columns) . " WHERE id = ?";
        $values[] = $id;

        $stmt = Connection::$db->prepare($sql);

        if ($stmt->execute($values)) {
            $response['success'] = true;
            $response['message'] = 'Prodotto aggiornato con successo.';
        } else {
            $response['message'] = 'Errore durante l\'aggiornamento del prodotto.';
        }
    } else {
        $response['message'] = 'Nessun dato da aggiornare.';
    }
} else {
    $response['message'] = 'Metodo di richiesta non valido o utente non autorizzato.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
