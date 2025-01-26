<?php

session_start();

$NOTIFICATIONS_TABLE = "notifica";

$empty_card = file_get_contents('../../src/views/template/templates/notification.html');

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
        $query = "
            SELECT *
            FROM " . $NOTIFICATIONS_TABLE . "
            WHERE id_utente = ?";
        if($daysOld > 0){
            $query .= " AND (DATEDIFF(CURRENT_DATE, timestamp) <= ? OR letta=0)";
        }
        $query .= " ORDER BY timestamp DESC";

        $stmt = Connection::$db->prepare($query);
        if($daysOld > 0){
            $stmt->bind_param("ii", $userId, $daysOld);
        } else {
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();

        $result = $stmt->get_result();

        foreach ($result as $row) {
            $card = $empty_card;
            $data = (new DateTime($row['timestamp']))->format('d/m/Y');
            
            if($row['letta'] == 0){
                $oggetto = "<strong>" . $row['oggetto'] . "</strong>";
            }else{
                $oggetto = $row['oggetto'];
            }
            $card = str_replace("{{ID}}", $row['id_notifica'], $card);
            $card = str_replace("{{OGGETTO}}", $oggetto, $card);
            $card = str_replace("{{DATA}}", $data, $card);
            $card = str_replace("{{MESSAGGIO}}", $row['messaggio'], $card);

            echo $card;
        }

        // Debugging: Check if there are any results
        if ($result->num_rows === 0) {
            echo "Nessuna notifica trovata.";
        }

    }else{
        echo "No sessione";
    }
} else {
    echo "No sessione";
}
