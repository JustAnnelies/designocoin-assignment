<?php

session_start();

require_once(__DIR__ . "/../src/services/transactionservice.php");
require_once(__DIR__ . "/../src/services/userservice.php");

// Creating new instance of the UserService class
$userService = new UserService();

// Call the public getUsers function
$users = $userService->getUsers();

// Include of the template needs to be done AFTER getting the users,
// otherwise $users can't be looped in the template.
include_once(__DIR__ . "/../src/views/transfer.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Creating new instance of the TransactionService class
    $transactionService = new TransactionService();

    // Call the public storeTransfer function
    $transactionService->storeTransaction($_POST);
}
