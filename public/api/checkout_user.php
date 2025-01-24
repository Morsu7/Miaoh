<?php

session_start();

$SHOPPING_TABLE = "acquisti";
$CART_TABLE = "carrello";
$SHOPPING_PRODUCTS_TABLE = "prodotti_acquistati";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/models/products/Product.php");
        require_once("../../src/models/products/ProductsManager.php");
        require_once("../../src/models/notifications/NotificationManager.php");
        require_once("../../src/config/connection.php");
        $user = Users::fromEmail($_SESSION['email']);
        $userId = $user->getId();

        $acquisti = ProductsManager::listFromUserCart($userId);

        $spesa_totale = 0;
        foreach($acquisti as $acquisto){
            if($acquisto['prodotto']->getQuantita() < $acquisto['quantita']){
                echo json_encode([
                    'success' => false,
                    'error' => 'quantity',
                    'product_id' => $acquisto['prodotto']->getId()
                ]);
                exit;
            }

            // Decrementa la quantità disponibile mostrata per il prodotto
            $stmt = Connection::$db->prepare("UPDATE prodotto SET quantita = quantita - ? WHERE id = ?");
            $prodottoId = $acquisto['prodotto']->getId();
            $stmt->bind_param("ii", $acquisto['quantita'], $prodottoId);
            $stmt->execute();
            if($stmt->affected_rows != 1){
                echo json_encode([
                    'success' => false,
                    'error' => 'Errore nella modifica della quantità disponibile'
                ]);
                exit;
            }

            $spesa_totale += $acquisto['prodotto']->getPrezzoScontato() * $acquisto['quantita'];
        }

        if(count($acquisti) == 0){
            echo json_encode([
                'success' => false,
                'error' => 'Nessun prodotto nel carrello'
            ]);
            exit;
        }

        $time = date('Y-m-d H:i:s');
        $stmt = Connection::$db->prepare("INSERT INTO acquisti (id_utente, timestamp, spesa) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $userId, $time, $spesa_totale);
        $stmt->execute();

        $orderId = $stmt->insert_id;

        foreach ($acquisti as $acquisto) {
            $prezzo_totale = $acquisto['prodotto']->getPrezzoScontato() * $acquisto['quantita'];
            $valori[] = "({$orderId}, {$acquisto['prodotto']->getId()}, {$acquisto['quantita']}, {$prezzo_totale})";
        }

        $valoriInStringa = implode(", ", $valori);

        $query = "INSERT INTO prodotti_acquistati (id_acquisto, id_prodotto, quantita, prezzo_totale) VALUES $valoriInStringa";

        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        if($stmt->affected_rows == count($acquisti)){
            $stmt = Connection::$db->prepare("DELETE FROM " . $CART_TABLE . " WHERE id_utente = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            if(NotificationManager::notificaNuovoOrdine($userId, $orderId)){
                echo json_encode([
                    'success' => true
                ]);
            }else{
                echo json_encode([
                    'success' => false,
                    'error' => 'Errore nell\'inserimento delle notifiche'
                ]);
            }
        }else{
            echo json_encode([
            'success' => false,
            'error' => "Errore nell'inserimento degli acquisti"
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
