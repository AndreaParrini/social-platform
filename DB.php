<?php

class DB
{
    public static function Connect()
    {
        define("DB_SERVERNAME", "localhost");
        define("DB_USERNAME", "root");
        define("DB_PASSWORD", "root");
        define("DB_NAME", "db_social_platform");

        $connection = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        /* var_dump($connection); */

        if ($connection && $connection->connect_error) {
            echo "Connection failed" . $connection->connect_error;
            die;
        }
        return $connection;
    }
}
