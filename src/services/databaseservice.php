<?php

class DatabaseService
{
    public function connect()
    {
        $host = 'mysql-database';
        $dbName = 'designocoin';
        $port = 3306;
        $dbUsername = 'root';
        $dbPassword = 'password';

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
