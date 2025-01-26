<?php

session_start();

require_once("../../src/models/users/User.php");
require_once("../../src/models/users/Users.php");
require_once("../../src/config/connection.php");

if(isset($_SESSION['email'])){
    $notificaId = $_POST['id_notifica'] ?? null;
    if($notificaId){
        $userId = Users::fromEmail($_SESSION['email'])->getId();

        $stmt = Connection::$db->prepare("SELECT id_utente FROM notifica WHERE id_notifica = ?");
        $stmt->bind_param("i", $notificaId);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row['id_utente'] == $userId){
            $stmt = Connection::$db->prepare("DELETE FROM notifica WHERE id_notifica = ?");
            $stmt->bind_param("i", $notificaId);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                echo json_encode([
                    'success' => true
                ]);
            }else{
                echo json_encode([
                    'success' => false,
                    'error' => 'Errore durante l\'eliminazione della notifica'
                ]);
            }
        }
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'Nessuna notifica selezionata'
        ]);
    }
}else{
    echo json_encode([
        'success' => false,
        'error' => 'No sessione'
    ]);
}
