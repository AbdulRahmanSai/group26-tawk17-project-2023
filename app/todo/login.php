<?php

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member login</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/app/templates/header.php'; ?>
    </header>
    <main class="container loginForm">
        <h1>Login Form</h1>
        <form action="/auth/signin.php" method="POST">
            <div class="formRow">
                <div class="formInput">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                </div>
            </div>
            <div class="formRow">
                <div class="formInput">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
            </div>
            <div class="formRow">
                <strong>Coach?</strong>
                <label class="switch">
                    <input type="checkbox" name="isCoachLogin">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="formRow">
                <input type="submit" value="Sign In">
                <button onclick="document.location='register.php'">Sign Up</button>
            </div>            
        </form>
        <br>
        <a href="#" title="Reset password">Forgot Password?</a>
        <br>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/validateErrors.php'; ?>
    </main>
    <footer class="footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/app/templates/footer.php'; ?>
    </footer>
</body>
</html>

<?php

// Unset session variables
unset($_SESSION['error']);
unset($_SESSION['member_error']);
unset($_SESSION['success']);
unset($_SESSION['member_success']);

?>