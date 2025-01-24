<?php
require_once("../../src/config/connection.php");

if (isset($_POST['q']) && isset($_POST['sort'])) {
    // Sanifica l'input dell'utente
    $query = htmlspecialchars(trim($_POST['q']), ENT_QUOTES, 'UTF-8');
    $category = isset($_POST['category']) ? intval($_POST['category']) : null;
    $sort = $_POST['sort'];
    $orderBy = 'id ASC'; // Ordinamento di default

    if ($sort === 'asc') {
        $orderBy = 'prezzo ASC';
    } elseif ($sort === 'desc') {
        $orderBy = 'prezzo DESC';
    }

    // Prepara la query SQL
    if ($category !== null && $category > 0) { // Verifica che la categoria sia valida
        $stmt = Connection::$db->prepare("
            SELECT id, nome, prezzo, img1,descrizione, sconto ,fine_sconto
            FROM prodotto 
            WHERE tipoProdotto_id = ? 
            && (MATCH(nome) AGAINST (? IN BOOLEAN MODE) 
            OR MATCH(descrizione) AGAINST (? IN BOOLEAN MODE)
            OR descrizione LIKE ?
            OR nome LIKE ? )
            ORDER BY $orderBy 
            LIMIT 21;
        ");
        // Costruisci i parametri
        $searchQueryFulltext = $query . '*'; // Per il MATCH
        $searchQueryLike = '%' . $query . '%'; // Per il LIKE
        $stmt->bind_param("issss",$category, $searchQueryFulltext,$searchQueryFulltext, $searchQueryLike, $searchQueryLike);
    } else {
        $stmt = Connection::$db->prepare("
            SELECT id, nome, prezzo, img1,descrizione, sconto ,fine_sconto
            FROM prodotto 
            WHERE MATCH(nome) AGAINST (? IN BOOLEAN MODE) 
            OR MATCH(descrizione) AGAINST (? IN BOOLEAN MODE)
            OR descrizione LIKE ?
            OR nome LIKE ?
            ORDER BY $orderBy 
            LIMIT 21;
        ");
        // Costruisci i parametri
        $searchQueryFulltext = $query . '*'; // Per il MATCH
        $searchQueryLike = '%' . $query . '%'; // Per il LIKE
        $stmt->bind_param("ssss", $searchQueryFulltext,$searchQueryFulltext, $searchQueryLike, $searchQueryLike);
    }

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
