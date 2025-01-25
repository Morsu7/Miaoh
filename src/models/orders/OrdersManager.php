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

    public static function fetchOrdersByPageAndFilters($page, $limit, $statusFilter = '', $searchId = '') {
        $offset = ($page - 1) * $limit;
        
        // Base query
        $query = "SELECT * FROM " . self::$ORDER_TABLE . " WHERE 1";
    
        // Add filters if they are provided
        if ($statusFilter) {
            $query .= " AND stato_acquisto = ?";
        }
        if ($searchId) {
            $query .= " AND id_acquisto LIKE ?";
        }
    
        // Add limit and offset
        $query .= " LIMIT ?, ?";
        
        // Prepare the statement
        $stmt = Connection::$db->prepare($query);
    
        // Bind parameters dynamically based on filters
        $searchIdStr = '%' . $searchId . '%';
        if ($statusFilter && $searchId) {
            $stmt->bind_param('ssii', $statusFilter, $searchIdStr, $offset, $limit);
        } elseif ($statusFilter) {
            $stmt->bind_param('sii', $statusFilter, $offset, $limit);
        } elseif ($searchId) {
            $stmt->bind_param('sii', $searchIdStr, $offset, $limit);
        } else {
            $stmt->bind_param('ii', $offset, $limit);
        }
    
        // Execute the query
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
    
    public static function getOrdersNumberWithFilters($searchId, $filterStatus) {
        // Base query
        $query = "SELECT COUNT(*) AS total FROM " . self::$ORDER_TABLE . " WHERE 1=1";
        
        // Add filters to the query
        if (!empty($searchId)) {
            $query .= " AND id_acquisto LIKE ?";
        }
        if (!empty($filterStatus)) {
            $query .= " AND stato_acquisto = ?";
        }
    
        // Prepare the query
        $stmt = Connection::$db->prepare($query);
        
        // Bind parameters dynamically based on filters
        $searchIdStr = '%' . $searchId . '%';
        if (!empty($searchId) && !empty($filterStatus)) {
            $stmt->bind_param('ss', $searchIdStr, $filterStatus); // 'ss' for two string parameters
        } elseif (!empty($searchId)) {
            $stmt->bind_param('s', $searchIdStr); // 's' for one string parameter
        } elseif (!empty($filterStatus)) {
            $stmt->bind_param('s', $filterStatus); // 's' for one string parameter
        }
    
        // Execute the statement
        $stmt->execute();
    
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}