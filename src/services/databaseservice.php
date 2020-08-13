<?php

class DatabaseService
{
    public function connect()
    {
        $host = 'localhost';
        $dbName = 'designocoin';
        $port = 8888;
        $dbUsername = 'root';
        $dbPassword = 'root';

        // PDO provides a data-access abstraction layer, which means that, regardless of which database you're using,
        // you use the same functions to issue queries and fetch data.
        try {
            $connection = new PDO('mysql:host=' . $host . ';dbname=' . $dbName . ';port:' . $port, $dbUsername, $dbPassword);
        } catch (PDOException $exception) {
            echo "Error!: " . $exception->getMessage();
            die();
        }

        return $connection;
    }
}
