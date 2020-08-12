<?php

require_once(__DIR__ . "/../src/services/userservice.php");
include_once(__DIR__ . "/../src/views/signup.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Creating new instance of the UserService class
    $userService = new UserService();

    // Call the public storeUser function
    $userId = $userService->storeUser($firstName, $lastName, $email, $password);

    // Call the public updateBalance function for the new user
    $signupGift = 10;
    $userService->updateUserBalance($userId, $signupGift);
}
