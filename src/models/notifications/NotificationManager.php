<?php

class NotificationManager
{

    private static $NOTIFICATION_TABLE = "notifica";

    private static function addNotifica($userId, $oggetto, $messaggio){
        $stmt = Connection::$db->prepare("INSERT INTO " . self::$NOTIFICATION_TABLE . " (id_utente, oggetto, messaggio) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $oggetto, $messaggio);
        $stmt->execute();
        
        return $stmt->affected_rows > 0;
    }

    public static function notificaNuovoOrdine($userId, $orderId){
        $oggetto = 'ORDINE ' . $orderId . ' INVIATO';
        $messaggio = 'Il tuo ordine [ID: #' . $orderId .'] è stato preso in carico con successo!
Ti invieremo una notifica appena sarà spedito. 

Grazie per aver scelto il nostro servizio!';

        return self::addNotifica($userId, $oggetto, $messaggio);
    }
}