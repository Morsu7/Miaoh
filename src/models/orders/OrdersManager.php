<?php

class OrdersManager {
    private static $ORDER_TABLE = 'acquisti';

    public static function fetchOrdersByPage($page, $ordersPerPage) {
        // Calcolo dell'offset per la query SQL
        $offset = ($page - 1) * $ordersPerPage;
    
        // Preparazione della query con LIMIT e OFFSET
        $stmt = Connection::$db->prepare("
            SELECT * FROM " . self::$ORDER_TABLE . "
            LIMIT ? OFFSET ?
        ");
    
        // Binding dei parametri per LIMIT e OFFSET
        $stmt->bind_param("ii", $ordersPerPage, $offset);
    
        // Esecuzione della query
        $stmt->execute();
    
        // Recupero del risultato
        $result = $stmt->get_result();
    
        $orders = [];
    
        // Iterazione sui risultati e creazione degli oggetti Order
        while ($row = $result->fetch_assoc()) {
            $orders[] = new Order(
                $row['id_utente'], 
                $row['id_acquisto'], 
                $row['timestamp'], 
                $row['stato_acquisto'], 
                $row['spesa']
            );
        }
    
        return $orders;
    }
    
    public static function getOrdersNumber() {
        $stmt = Connection::$db->prepare("
            SELECT COUNT(*) AS total FROM " . self::$ORDER_TABLE
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}