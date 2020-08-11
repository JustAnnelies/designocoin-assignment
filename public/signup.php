<?php

require_once(__DIR__ . "/../src/services/userservice.php");
include_once(__DIR__ . "/../src/views/signup.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Creating new instance of the UserService class
    $userService = new UserService();

    // Call the public storeUser function
    $userService->storeUser($_POST);
}
