<?php

class ProductsManager
{

    private static $PRODUCT_TABLE = "prodotto";
    private static $INTERACTION_TABLE = "interazione";

    public static function fromId($id){
        $stmt = Connection::$db->prepare("
            SELECT * FROM " . self::$PRODUCT_TABLE . "
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            return new Product($row['id'], $row['nome'], $row['descrizione'], $row['quantita'], $row['prezzo'], $row['sconto'], $row['fine_sconto'], $row['img1'], $row['img2'], $row['tipoProdotto_id']);
        }

        return null;
    }

    public static function getTrendingProducts($count){
        // Prima query: ottieni gli ID dei prodotti ordinati per numero di interazioni
        $stmt = Connection::$db->prepare("
            SELECT p.id, COUNT(i.id_prodotto) AS numero_interazioni
            FROM " . self::$PRODUCT_TABLE . " p
            JOIN interazione i ON p.id = i.id_prodotto
            WHERE i.timestamp >= NOW() - INTERVAL 10 DAY
            GROUP BY p.id
            ORDER BY numero_interazioni DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $count);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Cicla attraverso le righe risultanti e salva gli ID dei prodotti e il numero di interazioni
        $productIds = [];
        $interactionCounts = [];
        while ($row = $result->fetch_assoc()) {
            $productIds[] = $row['id'];
            $interactionCounts[$row['id']] = $row['numero_interazioni']; // Salva anche il numero di interazioni per ogni prodotto
        }
    
        // Se ci sono ID di prodotto, esegui una seconda query per ottenere i dettagli
        if (!empty($productIds)) {
            // Prepara la query per ottenere i dettagli dei prodotti
            $placeholders = implode(',', array_fill(0, count($productIds), '?')); // crea la stringa '?'
            $stmt = Connection::$db->prepare("
                SELECT * FROM " . self::$PRODUCT_TABLE . "
                WHERE id IN ($placeholders)
            ");
    
            // Lega i parametri dinamici per la seconda query
            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds); // Passa gli ID come parametri
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Crea un array di oggetti Product
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = new Product(
                    $row['id'],
                    $row['nome'],
                    $row['descrizione'],
                    $row['quantita'],
                    $row['prezzo'],
                    $row['sconto'],
                    $row['fine_sconto'],
                    $row['img1'],
                    $row['img2'],
                    $row['tipoProdotto_id']
                );
            }
    
            // Ordina i prodotti in base al numero di interazioni
            usort($products, function($a, $b) use ($interactionCounts) {
                $aInteractions = $interactionCounts[$a->getId()];
                $bInteractions = $interactionCounts[$b->getId()];
                return $bInteractions - $aInteractions; // Ordina in ordine decrescente
            });
    
            return $products;
        }
    
        return [];
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
            $products[] = new Product($row['id'], $row['nome'], $row['descrizione'], $row['quantita'], $row['prezzo'], $row['sconto'], $row['fine_sconto'], $row['img1'], $row['img2'], $row['tipoProdotto_id']);
        }
        return $products;
    }

    public static function listFromUserCart($id){
        $stmt = Connection::$db->prepare("
            SELECT 
                p.id,
                p.nome,
                p.descrizione,
                p.quantita,
                p.prezzo,
                p.sconto,
                p.fine_sconto,
                p.img1,
                p.img2,
                p.tipoProdotto_id,
                c.quantita as quantita_c
            FROM 
                carrello c
            JOIN 
                prodotto p ON c.id_prodotto = p.id
            WHERE 
                c.id_utente = ?;
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'prodotto' => new Product($row['id'], $row['nome'], $row['descrizione'], $row['quantita'], $row['prezzo'], $row['sconto'], $row['fine_sconto'], $row['img1'], $row['img2'], $row['tipoProdotto_id']),
                'quantita' => $row['quantita_c']
            ];
        }
        return $products;
    }
}