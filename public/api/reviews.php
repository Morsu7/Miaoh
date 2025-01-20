<?php
require_once("../../src/config/connection.php");

// Ensure that 'idProduct' is set and is a valid integer
$product_id = isset($_POST['idProduct']) && is_numeric($_POST['idProduct']) ? (int)$_POST['idProduct'] : null;

if ($product_id) {
    // Prepare the SQL query to fetch reviews with user data
    $stmt = Connection::$db->prepare("
        SELECT
            r.utente,
            r.prodotto_id,
            r.valutazione,
            r.descrizione,
            u.username AS nomeUtente,
            u.image_file_type AS fotoProfilo,
            r.data AS data
        FROM
            recensione r
        JOIN
            user u ON r.utente = u.id
        WHERE
            r.prodotto_id = ?
    ");
    
    $stmt->bind_param("i", $product_id); // Bind the product ID parameter
    
    if ($stmt->execute()) {
        // Execute the query and get the result
        $result = $stmt->get_result();
        
        // Fetch all reviews along with user data as an associative array
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        
        // Return the reviews with user data as a JSON response
        echo json_encode($reviews);
    } else {
        // If execution failed, send an error message
        echo json_encode(["error" => "Failed to execute query"]);
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an empty array if no valid product ID is provided
    echo json_encode([]);
}
?>

