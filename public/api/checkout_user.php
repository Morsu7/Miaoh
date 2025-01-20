<?php

session_start();

$SHOPPING_TABLE = "acquisti";
$CART_TABLE = "carrello";
$SHOPPING_PRODUCTS_TABLE = "prodotti_acquistati";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/config/connection.php");
        $user = Users::fromEmail($_SESSION['email']);
        $userId = $user->getId();

        $stmt = Connection::$db->prepare("SELECT id_prodotto, quantita FROM " . $CART_TABLE . " WHERE id_utente = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $acquisti = [];
        foreach($result as $prodotto){
            $acquisti[] = [
                'id_prodotto' => $prodotto['id_prodotto'],
                'quantita' => $prodotto['quantita']
            ];
        }

        if(count($acquisti) == 0){
            echo json_encode([
                'success' => false,
                'error' => 'Nessun prodotto nel carrello'
            ]);
            exit;
        }

        $time = date('Y-m-d H:i:s');
        $stmt = Connection::$db->prepare("INSERT INTO acquisti (id_utente, timestamp) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $time);
        $stmt->execute();

        $orderId = $stmt->insert_id;

        $stmt = Connection::$db->prepare("INSERT INTO " . $SHOPPING_PRODUCTS_TABLE . "(id_acquisto, id_prodotto, quantita) VALUES (?, ?, ?)");

        foreach ($acquisti as $prodotto_acquistato) {
            $valori[] = "({$orderId}, {$prodotto_acquistato['id_prodotto']}, {$prodotto_acquistato['quantita']})";
        }

        $valoriInStringa = implode(", ", $valori);

        $query = "INSERT INTO prodotti_acquistati (id_acquisto, id_prodotto, quantita) VALUES $valoriInStringa";

        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        if($stmt->affected_rows == count($acquisti)){
            $stmt = Connection::$db->prepare("DELETE FROM " . $CART_TABLE . " WHERE id_utente = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            echo json_encode([
                'success' => true
            ]);
        }else{
            echo json_encode([
            'success' => false,
            'errore' => "Errore nell'inserimento degli acquisti"
            ]);
        }
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'No sessione'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida.'
    ]);
}
