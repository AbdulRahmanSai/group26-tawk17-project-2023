<?php

// Require config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

  // Get form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate user
  $sql = "SELECT * FROM admins WHERE username='$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) :

    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) :

      /* Password is correct, start session */
      
      // Set session variables
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['type'] = 'admin';
      
      // Get session variables
      $_SESSION['admin_id'] = $row['admin_id'];
      
      // Redirect to dashboard
      header('Location: /app/admin/');
    
    else :      
      // Set session variables
      $_SESSION['admin_error'] = "Incorrect password";
      
      // Redirect to login page
      header('Location: /app/admin/login.php');
    endif;
  
  else :
    // Set session variables
    $_SESSION['admin_error'] = "Invalid login credentials";

    // Redirect to login page
    header('Location: /app/admin/login.php');
  endif;

endif;
?>