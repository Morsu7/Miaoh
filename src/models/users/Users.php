<?php

require_once "../src/models/users/User.php";

class Users{

    private static $USER_TABLE = "user";

    public static function fromEmail($email){
        // Query per ottenere i dati
        $stmt = Connection::$db->prepare("SELECT id, username, password_hash, name, surname, image_file_type FROM " . self::$USER_TABLE . " WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email); // "s" per indicare che il parametro è una stringa
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 1) { // Se l'utente esiste
            $user = $result->fetch_assoc();

            return new User($user['id'], $user['username'], $email, $user['password_hash'], $user['name'], $user['surname'], $user['image_file_type']);
        }

        return ""; // Non esiste questa email nel database
    }

    public static function updateImage($email, $image){
        if($image['error'] === UPLOAD_ERR_OK){
            $fileName = $image['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            self::updateImageExtension($email, $fileExtension);
        }
    }

    private static function updateImageExtension($email, $extension){
        $stmt = Connection::$db->prepare("UPDATE " . self::$USER_TABLE . " SET image_file_type= ? WHERE email = ? LIMIT 1");
        $stmt->bind_param("ss", $extension, $email);
        $stmt->execute();
    }

    public static function updateName($email, $name){
        $stmt = Connection::$db->prepare("UPDATE " . self::$USER_TABLE . " SET name= ? WHERE email = ? LIMIT 1");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
    }

    public static function updateSurname($email, $surname){
        $stmt = Connection::$db->prepare("UPDATE " . self::$USER_TABLE . " SET surname= ? WHERE email = ? LIMIT 1");
        $stmt->bind_param("ss", $surname, $email);
        $stmt->execute();
    }
}
?>