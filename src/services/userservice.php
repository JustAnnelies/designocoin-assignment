<?php

require_once(__DIR__ . "/databaseservice.php");
require_once(__DIR__ . "/../models/user.php");

class UserService
{
    public function login($email, $password)
    {
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
        
        if (!$isCorrectPassword) {
            throw new Exception("Incorrect login credentials");
        }
        
        // Store email in session
        // The default behaviour of the session cookie is that it will expire when the browser is closed.
        if ($isCorrectPassword) {
            $_SESSION['email'] = $email;
        }
    }

    public function logout()
    {
        // Unset all of the session variables
        $_SESSION = [];

        // Delete session cookie
        $cookieParams = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $cookieParams['path'],
            $cookieParams['domain'],
            $cookieParams['secure'],
            $cookieParams['httponly']
        );

        // Destroy the session
        session_destroy();
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

    public function getUserBalance($userId)
    {
        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare('SELECT balance FROM users WHERE id = :userId');

        // Execute query
        $preparedStatement->execute(
            [
                'userId' => $userId,
            ]
        );

        // Get SQL result
        return $preparedStatement->fetch(Pdo::FETCH_ASSOC);
    }

    public function storeUser($firstName, $lastName, $email, $password)
    {
        // Create instance of User
        // This will only create the instance if the given data is valid
        $user = new User($firstName, $lastName, $email, $password);

        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'INSERT INTO users (firstname, lastname, email, password, balance)
            VALUES (:firstname, :lastname, :email, :password, 0)'
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

        return $connection->lastInsertId();
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
