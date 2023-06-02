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
    <title>Member registration</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
    </header>
    <main class="container registerForm">
        <h1>Member Registration Form</h1>    
        <form action="/auth/signup.php" method="POST" >
            <div class="formRow">
                <div class="formInput">
                    <label for="firstname">First name</label>
                    <input type="text" name="firstname" required>
                </div>
                <div class="formInput">
                    <label for="lastname">Last name</label>
                    <input type="text" name="lastname" required>
                </div>
            </div>
            <div class="formRow">
                <div class="formInput">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="formInput">
                    <label for="mobile">Mobile number</label>
                    <input type="text" name="mobile" required>
                </div>
            </div>
            <div class="formRow">
                <div class="formInput">
                    <label for="coachcode">Register code</label>
                    <input type="number" name="coachcode" required>
                </div>
                <div class="formInput">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>
            </div>
            <div class="formRow">
                <div class="formInput">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div class="formInput">
                    <label for="cpassword">Comfirm Password:</label>
                    <input type="password" name="cpassword" required>
                </div>
            </div>
            <div class="formRow">
                <strong>Coach?</strong>
                <label class="switch">
                    <input type="checkbox" name="isCoachRegister">
                    <span class="slider round"></span>
                </label>
            </div>
            <input type="submit" value="Sign Up">
            <button onclick="document.location='login.php'">Sign In</button>
        </form>
        <br>
        <?php include '/modules/validateErrors.php'; ?>
    </main>
    <footer class="footer">
      <?php include '../../app/templates//footer.php'; ?>
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