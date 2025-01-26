<?php
session_start();
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0") {
    require_once("../../../src/config/connection.php");

    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id']) && !empty($input['id'])) {
        $id = intval($input['id']);

        $imageDirectory = __DIR__ . "../../../assets/images/productimages/";
        $extensions = ['jpg', 'jpeg', 'png'];

        foreach ($extensions as $ext) {
            $imagePath = "$imageDirectory/$id.$ext";
            if (file_exists($imagePath)) {
                // Eliminazione del file immagine
                if (unlink($imagePath)) {
                    break;
                } else {
                    $response['message'] = 'Errore durante l\'eliminazione dell\'immagine.';
                    echo json_encode($response);
                    exit;
                }
            }
        }

        // Query SQL per eliminare il prodotto
        $sql = "DELETE FROM prodotto WHERE id = ?";
        $stmt = Connection::$db->prepare($sql);
    
        if ($stmt->execute([$id])) {
            $response['success'] = true;
            $response['message'] = 'Prodotto eliminato con successo.';
        } else {
            $response['message'] = 'Errore durante l\'eliminazione del prodotto.';
        }
    } else {
        $response['message'] = 'ID prodotto mancante.';
        echo json_encode($response);
    }
} else {
    $response['message'] = 'Metodo non valido.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
