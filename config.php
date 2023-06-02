<?php

// Start session
session_start();

// Database configuration
$db_host = 'localhost';
$db_username = 'todozone';
$db_password = 'bN7F)26uAcbJhFcu';
$db_name = 'todozone';

// Create connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check for errors
if (!$conn) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
endif;
/*
elseif ($conn) :
    echo "Connected successfully!";
endif;
*/

?>