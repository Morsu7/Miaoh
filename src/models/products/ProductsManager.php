<?php

class ProductsManager
{

    private static $PRODUCT_TABLE = "prodotto";
    private static $INTERACTION_TABLE = "interazione";

    public static function getTrendingProducts($count){
        // Query per ottenere gli id dei prodotti più richiesti negli ultimi 10 giorni
        $stmt = Connection::$db->prepare("
            SELECT p.id, COUNT(i.id_prodotto) AS numero_interazioni 
            FROM " . self::$PRODUCT_TABLE . " p 
            JOIN interazione i ON p.id = i.id_prodotto 
            WHERE i.timestamp >= NOW() - INTERVAL 10 DAY 
            GROUP BY p.id 
            ORDER BY numero_interazioni DESC 
            LIMIT ?");
        $stmt->bind_param("i", $count);
        $stmt->execute();
        $result = $stmt->get_result();
        // Cicla attraverso le righe risultanti
        while ($row = $result->fetch_assoc()) {
            $productIds[] = $row['id'];
        }

        // Se ci sono ID di prodotto, esegui una seconda query per ottenere i dettagli
        if (!empty($productIds)) {
            // Prepara la query per ottenere i dettagli dei  prodotti
            $placeholders = implode(',', array_fill(0, count($productIds), '?')); // crea la stringa '?'
            $stmt = Connection::$db->prepare("
                SELECT * 
                FROM " . self::$PRODUCT_TABLE . "
                WHERE id IN ($placeholders)
            ");

            // Lega i parametri dinamici per la seconda query
            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds); // Passa gli ID come parametri
            // Esegui la seconda query
            $stmt->execute();
            $result = $stmt->get_result();
        }

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row['id'], $row['nome'], $row['descrizione'], $row['quantita'], $row['prezzo'], $row['sconto'], $row['fine_sconto'], $row['img1'], $row['img2'], $row['tipoProdotto_id'], );
        }

        return $products;
    }

    public static function getRandomProducts($count){
        $stmt = Connection::$db->prepare("
                SELECT * 
                FROM " . self::$PRODUCT_TABLE . "
                ORDER BY RAND()
                LIMIT ?;
            ");
        $stmt->bind_param("i", $count);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row['id'], $row['nome'], $row['descrizione'], $row['quantita'], $row['prezzo'], $row['sconto'], $row['fine_sconto'], $row['img1'], $row['img2'], $row['tipoProdotto_id'], );
        }

        return $products;
    }
}