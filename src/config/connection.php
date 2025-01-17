<?php

/************************************************************************
 Definisco la class Connection che rappresenta la connessione verso il database,
 l' obbiettivo è quello di creare una sola volta la connessione ed usarla per
 tutta la durata dello script
 *************************************************************************/

class Connection {
  public static $db;
  public function __construct() {
    self::$db = new \mysqli('127.0.0.1', 'root', '', 'miaoh_db');
    mysqli_set_charset(self::$db,'utf8mb4');
  }
}
/* Definita la classe provvedo ad utilizzarla */

new Connection();
//Verifico che la connessione sia andata a buon fine
if (Connection::$db->connect_error) {
  die("Impossibile stabilire la connessione con il database.");
}

/**********************************************************************
Da questo momento la connesione è raggiungibile attraverso la proprietà
statica $db della classe  Connection

Esempio:

Connection::$db->query(....)

************************************************************************/