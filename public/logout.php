<?php

session_start();

require_once(__DIR__ . "/../src/services/userservice.php");

// Creating new instance of the UserService class
$userService = new UserService();

// Call the public logout function
$userService->logout();

// Redirect to index page
header('Location: index.php');
