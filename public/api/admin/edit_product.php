<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0") {
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
        'fine_sconto' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^\d{4}-\d{2}-\d{2}$/', // Formato data: YYYY-MM-DD
            ]
        ],
        'tipoProdotto_id' => FILTER_VALIDATE_INT,
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
        // Ottieni l'estensione del file
        $imageExt = pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION);
        
        // Crea il nuovo nome per l'immagine come id.estensione
        $imagePath = __DIR__ . '../../../assets/images/productimages/' . $id . '.' . $imageExt;
        $existingImagePath = __DIR__ . '../../../assets/images/productimages/' . $id . '.*';  // Cerca file con nome id.* (qualsiasi estensione)
        $files = glob($existingImagePath);  // Cerca il file con nome id.* (qualsiasi estensione)

        // Se esistono file, rimuovi il primo che trova
        if (count($files) > 0) {
            unlink($files[0]);  // Rimuovi il file esistente
        }

        // Salva la nuova immagine con il nome id.estensione
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $imagePath)) {
            // Aggiorna il database con il nuovo percorso dell'immagine
            $columns[] = "img1 = ?";
            $values[] = $imageExt;
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
