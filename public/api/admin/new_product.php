<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin'])) {
    require_once("../../../src/config/connection.php");

    // Directory per il caricamento delle immagini
    $targetDir = __DIR__ . "../../../assets/images/productimages/";
    $response = [];
    $uploadOk = true;

    // Funzione per gestire il caricamento di una singola immagine
    function uploadImage($file, $targetDir, &$response)
    {
        $fileName = basename($file['name']);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        // Verifica del tipo di file
        if (!in_array($imageFileType, $allowedTypes)) {
            $response['message'] = "Solo file JPG, JPEG, PNG sono consentiti.";
            return [false, null];
        }

        // Caricamento del file
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return [true, $imageFileType];
        } else {
            $response['message'] = "Errore durante il caricamento dell'immagine.";
            return [false, null];
        }
    }

    // Carica le immagini
    $fullFileName = $_FILES['img1']['name'];
    list($uploadImg1Ok, $imgExtension) = uploadImage($_FILES['img1'], $targetDir, $response);
    
    // Controlla se entrambe le immagini sono state caricate correttamente
    if ($uploadImg1Ok) {
        // Estrai i dati dal form
        $nome = $_POST['nome'] ?? '';
        $descrizione = $_POST['descrizione'] ?? '';
        $quantita = $_POST['quantita'] ?? 0;
        $prezzo = $_POST['prezzo'] ?? 0;
        $sconto = $_POST['sconto'] ?? 0;
        $fineSconto = $_POST['fineSconto'] ?? '';
        $tipoProdottoId = $_POST['tipoProdottoId'] ?? 0;

        // Query per inserire il prodotto
        $stmt = Connection::$db->prepare("
            INSERT INTO prodotto (nome, descrizione, quantita, prezzo, sconto, fine_sconto, img1, tipoProdotto_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssiddssi",
            $nome,
            $descrizione,
            $quantita,
            $prezzo,
            $sconto,
            $fineSconto,
            $imgExtension,
            $tipoProdottoId
        );

        if ($stmt->execute()) {
            $productId = $stmt->insert_id;

            rename($targetDir . $fullFileName, $targetDir . $productId . '.' . $imgExtension);

            $response["success"] = true;
            $response['message'] = "Prodotto aggiunto con successo.";
        } else {
            $response['message'] = "Errore durante l'inserimento del prodotto.";
        }
    } else {
        $uploadOk = false;
    }
} else {
    $response['message'] = "Richiesta non valida o file immagine mancante.";
}

header('Content-Type: application/json');
echo json_encode($response);