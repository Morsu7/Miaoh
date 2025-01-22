<?php
require_once("../../src/config/connection.php");

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$category = isset($_POST['category']) ? intval($_POST['category']) : null;
$sort = isset($_POST['sort']) ? $_POST['sort'] : '';
$orderBy = 'id ASC'; // Ordinamento di default

if ($sort === 'asc') {
    $orderBy = 'prezzo ASC';
} elseif ($sort === 'desc') {
    $orderBy = 'prezzo DESC';
}

$limit=20;
$offset=$page*$limit;

// Costruzione della query
if ($category !== null && $category > 0) { // Verifica che la categoria sia valida
    $query = "SELECT id, nome, descrizione, prezzo, sconto, fine_sconto, img1 
              FROM prodotto 
              WHERE tipoProdotto_id = ? 
              ORDER BY $orderBy 
              LIMIT ? OFFSET ?";
    $stmt = Connection::$db->prepare($query);
    $stmt->bind_param("iii", $category, $limit, $offset);
} else {
    $query = "SELECT id, nome, descrizione, prezzo, sconto, fine_sconto, img1 
              FROM prodotto 
              ORDER BY $orderBy 
              LIMIT ? OFFSET ?";
    $stmt = Connection::$db->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
?>
