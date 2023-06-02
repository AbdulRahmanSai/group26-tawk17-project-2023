<?php

// Start or resume the session
session_start();

// Unset session variables
unset($_SESSION["loggedin"]);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['type']);
unset($_SESSION['coach_id']);

// Destroy session
session_destroy();

// Redirect to login page
header('Location: /app/todo/login.php');
?>