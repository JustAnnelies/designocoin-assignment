<?php

session_start();

require_once(__DIR__ . "/../src/services/userservice.php");

// Creating new instance of the UserService class
$userService = new UserService();

// Call the public getLoggedInUser function
$loggedInUser = $userService->getLoggedInUser();

// Return HTTP status code 401 (unauthorized) in case the user is not logged in
if (!$loggedInUser) {
    header('HTTP/1.1 401 Unauthorized');
    die();
}

// Call the public getUserBalance function
$userBalance = $userService->getUserBalance($loggedInUser['id']);

echo $userBalance['balance'];
