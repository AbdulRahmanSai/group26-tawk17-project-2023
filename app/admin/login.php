<?php

// Start session
session_start();

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
    </header>
    <main class="container">
        <h1>Login Form</h1>
        <form action="signin.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Sign In">
            <button onclick="document.location='register.php'">Sign Up</button>
        </form>
        <br>
        <a href="#" title="Reset password">Forgot Password?</a>
        <br>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/validateErrors.php'; ?>
    </main>
    <footer class="footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/footer.php'; ?>
    </footer>
</body>
</html>