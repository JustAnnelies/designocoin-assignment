<?php

session_start();

require_once(__DIR__ . "/../src/services/transactionservice.php");
require_once(__DIR__ . "/../src/services/userservice.php");

// Sanitize input
$transactionId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// Creating new instance of the UserService class
$userService = new UserService();

// Creating new instance of the TransactionService class
$transactionService = new TransactionService();

// Call the public getLoggedInUser function
$loggedInUser = $userService->getLoggedInUser();

// Call the public getTransaction function
$transaction = $transactionService->getTransaction($transactionId);

// Include of the template needs to be done AFTER getting the transaction,
// otherwise $transaction isn't accessible in the template.
include_once(__DIR__ . "/../src/views/transaction.php");
