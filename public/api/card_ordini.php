<?php

session_start();

$CART_TABLE = "carrello";
$SHOPPING_TABLE = "acquisti";

$empty_card = file_get_contents('../../src/views/template/templates/card.html');
$empty_item_in_card = file_get_contents('../../src/views/template/templates/item_in_card.html');

// Debugging: Check if the template is loaded correctly
if ($empty_card === false) {
    echo "Failed to load template file.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['daysOld'])) {
    if(isset($_SESSION['email'])){
        require_once("../../src/models/users/User.php");
        require_once("../../src/models/users/Users.php");
        require_once("../../src/config/connection.php");

        $userId = Users::fromEmail($_SESSION['email'])->getId();
        $daysOld = intval($_POST['daysOld']);

        $stmt = Connection::$db->prepare("
            SELECT id_acquisto, timestamp, stato_acquisto, spesa
            FROM " . $SHOPPING_TABLE . "
            WHERE id_utente = ? AND DATEDIFF(CURRENT_DATE, timestamp) <= ?");
        $stmt->bind_param("ii", $userId, $daysOld);
        $stmt->execute();

        $result = $stmt->get_result();

        foreach ($result as $row) {
            $card = $empty_card;
            $data = (new DateTime($row['timestamp']))->format('Y-m-d');
            switch ($row['stato_acquisto']) {
                case 'da_spedire':
                    $statusText = 'Da spedire';
                    break;
                case 'spedito':
                    $statusText = 'Spedito';
                    break;
                case 'consegnato':
                    $statusText = 'Consegnato';
                    break;
                default:
                    $statusText = 'Unknown';
                    break;
            }
            $card = str_replace("{{ORDERSTATUS}}", $statusText, $card);

            $card = str_replace("{{ORDERDATE}}", $data, $card);
            $card = str_replace("{{ORDERID}}", $row['id_acquisto'], $card);
            $card = str_replace("{{ORDERSTATUS}}", $statusText, $card);
            $card = str_replace("{{ORDERPRICE}}", $row['spesa'], $card);

            $stmt = Connection::$db->prepare("
                SELECT id_prodotto, pa.quantita, prezzo_totale, p.nome, p.img1
                FROM prodotti_acquistati pa
                JOIN prodotto p ON pa.id_prodotto = p.id
                WHERE id_acquisto = ?");
            $stmt->bind_param("i", $row['id_acquisto']);
            $stmt->execute();
            $prodotti = $stmt->get_result();
            $items = "";
            foreach($prodotti as $prodotto){
                $items .= $empty_item_in_card;
                $items = str_replace("{{ITEM_IMAGE}}", "public/assets/images/productimages/" . $prodotto['id_prodotto'] . "." . $prodotto['img1'], $items);
                $items = str_replace("{{ITEM_NAME}}", $prodotto['nome'], $items);
                $items = str_replace("{{ITEM_QUANTITY}}", $prodotto['quantita'], $items);
                $items = str_replace("{{ITEM_ID}}", $prodotto['id_prodotto'], $items);
                $items = str_replace("{{ITEM_PRICE}}", $prodotto['prezzo_totale'], $items);
            }

            $card = str_replace("{{ORDER_PRODUCTS}}", $items, $card);

            echo $card;
        }

        // Debugging: Check if there are any results
        if ($result->num_rows === 0) {
            echo "No orders found.";
        }

    }else{
        echo "No sessione";
    }
} else {
    echo "No sessione";
}
