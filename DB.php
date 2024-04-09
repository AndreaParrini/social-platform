<?php

class DB
{
    /**
     * Function to connect with databse
     * @return param of connection with DB
     */
    public static function Connect()
    {
        /* definisco tutti i dati necessari per collegarmi al database */
        define("DB_SERVERNAME", "localhost");
        define("DB_USERNAME", "root");
        define("DB_PASSWORD", "root");
        define("DB_NAME", "db_social_platform");

        /* associo a $connection il risultato restuito dalla funzione mysqli() */
        $connection = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        /* var_dump($connection); */

        /* controllo se nella variabile $connesction c'è un errore e nel caso stampo in pagina l'errore ricevuto */
        if ($connection && $connection->connect_error) {
            echo "Connection failed" . $connection->connect_error;
            die;
        }
        return $connection;
    }

    /**
     * Function to close connection whit database
     * @param $connection param that contain the connection with DB
     */
    public static function Close($connection)
    {
        $connection->close();
    }
}
