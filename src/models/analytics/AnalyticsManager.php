<?php

class AnalyticsManager {
    private static $ORDERS_TABLE = "acquisti";
    private static $USERS_TABLE = "user";

    // Recupera il totale degli ordini
    public static function getOrdersTotal() {
        $query = "SELECT COUNT(*) as total_orders FROM " . self::$ORDERS_TABLE;
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        // Restituisce il totale
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total_orders'];
    }

    // Recupera il numero di ordini pendenti
    public static function getOrdersPending() {
        $query = "SELECT COUNT(*) as pending_orders FROM " . self::$ORDERS_TABLE . " WHERE stato_acquisto = 'da_spedire'";
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        // Restituisce gli ordini pendenti
        $result = $stmt->get_result();
        return $result->fetch_assoc()['pending_orders'];
    }

    // Recupera il numero di ordini spediti
    public static function getOrdersShipped() {
        $query = "SELECT COUNT(*) as shipped_orders FROM " . self::$ORDERS_TABLE . " WHERE stato_acquisto = 'spedito'";
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        // Restituisce gli ordini spediti
        $result = $stmt->get_result();
        return $result->fetch_assoc()['shipped_orders'];
    }

    // Recupera il numero di ordini consegnati
    public static function getOrdersDelivered() {
        $query = "SELECT COUNT(*) as delivered_orders FROM " . self::$ORDERS_TABLE . " WHERE stato_acquisto = 'consegnato'";
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        // Restituisce gli ordini consegnati
        $result = $stmt->get_result();
        return $result->fetch_assoc()['delivered_orders'];
    }

    // Recupera il numero di utenti registrati
    public static function getUsersRegistered() {
        $query = "SELECT COUNT(*) as registered_users FROM " . self::$USERS_TABLE;
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();

        // Restituisce il numero di utenti registrati
        $result = $stmt->get_result();
        return $result->fetch_assoc()['registered_users'];
    }

    public static function getPurchasesByDate() {
        $query = "SELECT DATE(timestamp) as purchase_date, COUNT(*) as total_purchases 
                  FROM " . self::$ORDERS_TABLE . " 
                  GROUP BY purchase_date
                  ORDER BY purchase_date ASC";
    
        $stmt = Connection::$db->prepare($query);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = [];
    
        // Carica i dati in un array
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'date' => $row['purchase_date'],
                'total_purchases' => $row['total_purchases']
            ];
        }
        return $data;
    }
}