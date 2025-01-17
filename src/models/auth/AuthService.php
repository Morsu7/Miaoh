<?php

class AuthService {

    private static $USER_TABLE = "user";

    public static function auth_register($email, $password){
        // Verifica che email e password non siano vuoti
        if (empty($email) || empty($password)) {
            return "error"; // Email e password sono obbligatori
        }

        // Connessione al database tramite mysqli (assumendo che Connection::$db sia già configurato)
        $db = Connection::$db;

        // Verifica che l'email non esista già nel database
        $stmt = $db->prepare("SELECT email FROM " . self::$USER_TABLE . " WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email); // "s" per indicare che il parametro è una stringa
        $stmt->execute();
        $stmt->store_result();

        // Se l'email esiste già, restituisci un errore
        if ($stmt->num_rows > 0) {
            return "email_already_exists"; // L'email è già registrata
        }

        // Se l'email non esiste, procedi con la registrazione
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Crittografa la password

        // Prepara la query per inserire il nuovo utente
        $stmt = $db->prepare("INSERT INTO " . self::$USER_TABLE . " (email, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password); // "ss" per due stringhe

        // Esegui la query di inserimento
        if ($stmt->execute()) {
            return "success"; // Registrazione completata con successo
        } else {
            return "error"; // Si è verificato un errore durante la registrazione
        }

        // Chiudi la dichiarazione
        $stmt->close();
    }


    public static function auth_login($email, $password) {
        if (empty($email) || empty($password)) {
            //echo 'Email e password sono obbligatori.';
            return "invalid_email";
        }

        // Prepara la query per ricercare l'email all'interno del sito e verificare la password inserita
        $stmt = Connection::$db->prepare("SELECT email, password_hash FROM " . self::$USER_TABLE . " WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email); // "s" per indicare che il parametro è una stringa
        
        // Esegui la query
        $stmt->execute();

        // Ottieni il risultato
        $result = $stmt->get_result();

        // Verifica se l'utente esiste
        if ($result->num_rows === 1) { // Se l'utente esiste
            // Recupera i dati dell'utente
            $user = $result->fetch_assoc();
            
            // Verifica la password
            if (password_verify($password, $user['password_hash'])) {
                // La password è corretta, autenticazione riuscita
                return "success";
            } else {
                // La password è errata
                return "invalid_password";
            }
        }

        // Email non trovata
        return "invalid_email";
    }
}