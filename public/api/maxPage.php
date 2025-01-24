<?php
require_once("../../src/config/connection.php");

$response = ["status" => "error", "message" => "Errore"]; // Default error response

$query = "SELECT COUNT(*) as num FROM prodotto";
$stmt = Connection::$db->prepare($query);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $numProduct = intval($row['num']);
        $maxPage = ceil($numProduct / 21);
        $response = ["status" => "success", "maxPage" => $maxPage];
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
