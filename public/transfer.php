<?php

session_start();

require_once(__DIR__ . "/../src/services/transactionservice.php");
require_once(__DIR__ . "/../src/services/userservice.php");

// Creating new instance of the UserService class
$userService = new UserService();

// Call the public getLoggedInUser function
$loggedInUser = $userService->getLoggedInUser();

// Call the public getUsers function
$users = $userService->getUsers();

// Include of the template needs to be done AFTER getting the users,
// otherwise $users can't be looped in the template.
include_once(__DIR__ . "/../src/views/transfer.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $userIdReceiver = filter_var($_POST['receiver'], FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    // Creating new instance of the TransactionService class
    $transactionService = new TransactionService();

    // Call the public storeTransfer function
    $transactionService->storeTransaction($loggedInUser, $userIdReceiver, $amount, $description);

    // Call the public updateBalance function for the payer
    $userService->updateUserBalance($loggedInUser['id'], -$_POST['amount']);

    // Call the public updateBalance function for the receiver
    $userService->updateUserBalance($_POST['receiver'], $_POST['amount']);
}
