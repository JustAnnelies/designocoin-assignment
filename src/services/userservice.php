<?php

require_once(__DIR__ . "/databaseservice.php");
require_once(__DIR__ . "/../models/user.php");

class UserService
{
    public function storeUser(array $data)
    {
        // Create instance of User
        // This will only create the instance if the given data is valid
        $user = new User($data['firstname'], $data['lastname'], $data['email'], $data['password']);

        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'INSERT INTO users (firstname, lastname, email, password)
            VALUES (:firstname, :lastname, :email, :password)'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'firstname' => $user->getFirstName(),
                'lastname' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]
        );
    }

    private function getDatabaseConnection()
    {
        $connection = new DatabaseService();

        return $connection->connect();
    }
}
