<?php

require_once(__DIR__ . "/databaseservice.php");
require_once(__DIR__ . "/../models/user.php");

class UserService
{
    public function login(array $data)
    {
        // Get input data
        $email = $data['email'];
        $password = $data['password'];

        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'email' => $email,
            ]
        );

        // Get SQL result
        $sqlResult = $preparedStatement->fetch(Pdo::FETCH_ASSOC);
        $hashedPassword = $sqlResult['password'];

        // Check if inputted password matches the one in the database
        $isCorrectPassword = password_verify($password, $hashedPassword);

        // Store email in session
        // The default behaviour of the session cookie is that it will expire when the browser is closed.
        if ($isCorrectPassword) {
            $_SESSION['email'] = $email;
        }
    }

    public function logout()
    {
        // Delete session
    }

    public function getLoggedInUser()
    {
        $email = $_SESSION['email'];

        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'email' => $email,
            ]
        );

        // Get SQL result
        return $preparedStatement->fetch(Pdo::FETCH_ASSOC);
    }

    public function getUsers()
    {
        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare('SELECT * FROM users');

        // Execute query
        $preparedStatement->execute();

        // Get SQL result
        return $preparedStatement->fetchAll(Pdo::FETCH_ASSOC);
    }

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

    public function updateUserBalance($userId, $amount)
    {
        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'UPDATE users SET balance = balance + :balance WHERE id = :user_id'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'balance' => $amount,
                'user_id' => $userId,
            ]
        );
    }

    private function getDatabaseConnection()
    {
        $connection = new DatabaseService();

        return $connection->connect();
    }
}
