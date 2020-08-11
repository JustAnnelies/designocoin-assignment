<?php

require_once(__DIR__ . "/../src/services/userservice.php");
include_once(__DIR__ . "/../src/views/signup.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Creating new instance of the UserService class
    $userService = new UserService();

    // Call the public storeUser function
    $userId = $userService->storeUser($_POST);

    // Call the public updateBalance function for the new user
    $signupGift = 10;
    $userService->updateUserBalance($userId, $signupGift);
}
