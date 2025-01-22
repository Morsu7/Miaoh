<?php
require_once("../../src/config/connection.php");

if (isset($_POST['q'])) {
    // Sanifica l'input dell'utente
    $query = htmlspecialchars(trim($_POST['q']), ENT_QUOTES, 'UTF-8');

    // Prepara la query SQL
    $stmt = Connection::$db->prepare("
        SELECT id, nome, prezzo, img1,descrizione, sconto ,fine_sconto
        FROM prodotto 
        WHERE MATCH(nome) AGAINST (? IN BOOLEAN MODE) 
        OR MATCH(descrizione) AGAINST (? IN BOOLEAN MODE)
        OR descrizione LIKE ?
        OR nome LIKE ?
        LIMIT 10;
    ");

    // Costruisci i parametri
    $searchQueryFulltext = $query . '*'; // Per il MATCH
    $searchQueryLike = '%' . $query . '%'; // Per il LIKE

    $stmt->bind_param("ssss", $searchQueryFulltext,$searchQueryFulltext, $searchQueryLike, $searchQueryLike);

    // Esegui la query
    $stmt->execute();

    $result = $stmt->get_result();

    // Ottieni i risultati
    $products= [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
