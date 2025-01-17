<?php

class Users{

    private static $USER_TABLE = "user";

    public static function fromEmail($email){
        // Query per ottenere i dati
        $stmt = Connection::$db->prepare("SELECT id, username, password_hash, name, surname FROM " . self::$USER_TABLE . " WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email); // "s" per indicare che il parametro è una stringa
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 1) { // Se l'utente esiste
            $user = $result->fetch_assoc();

            return new User($user['id'], $user['username'], $email, $user['password_hash'], $user['name'], $user['surname']);
        }

        return ""; // Non esiste questa email nel database
    }
}
?>