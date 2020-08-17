<?php

session_start();

require_once(__DIR__ . "/../src/services/userservice.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Creating new instance of the UserService class
    $userService = new UserService();
    
    try {
        // Call the public login function
        $userService->login($email, $password);
        // Redirect to transactions page
        header('Location: transactions.php');
    } catch (Exception $exception) {
        // Hier kan je bijv. een $error variable ‘setten’, om weer te geven in het login formulier.
        $error = $exception->getMessage();
    }    

}
include_once(__DIR__ . "/../src/views/login.php");
