<?php

// Require config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

/* User:Member Signin logic */

// Require Login Validation
//require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

  // Get form data
  $username = $_POST['username'];
  $password = $_POST['password'];
  $isCoachLogin = $_POST['isCoachLogin'];

  /*
  * Checking submitting user if a Coach
  * OR member
  */
  if ($isCoachLogin) :
    echo "coach";
    
    // Validate coach
    $sql = "SELECT * FROM coaches WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) :
      $row = $result->fetch_assoc();

      /* Check if Coach account is active of inactive */
      if ($row['status'] == "active") :

        // Verify password
        if ($row['password']) :
          /* Password is correct, start session */
          
          // Set session variables
          $_SESSION['loggedin'] = true;
          $_SESSION['username'] = $username;
          $_SESSION['type'] = 'coach';

          // Get session variables
          $_SESSION['id'] = $row['id'];

          // Redirect to dashboard
          header('Location: /app/todo/coach/');
        
        else :
          // Set session variables
          $_SESSION['coach_error'] = "Incorrect password";

          // Redirect to login page
          header('Location: /app/todo/login.php');
        endif;
      
      elseif ($row['status'] == "inactive") :
        $_SESSION['coach_error'] = "Your account is not active yet!";
        
        // Redirect to login page
        header('Location: /app/todo/login.php');
      endif;
    else :
      // Set session variables
      $_SESSION['coach_error'] = "Invalid login credentials";
    
      // Redirect to login page
      header('Location: /app/todo/login.php');
    endif;
  
  // If the user is a member
  elseif (!$isCoachLogin):
    echo "mamber";

    // Validating the user
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) :

      $row = $result->fetch_assoc();

      // Verify password
      if (password_verify($password, $row['password'])) :

        /* Password is correct, start session */
        
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['type'] = 'member';
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['coach_id'] = $row['coach_id'];      
        
        // Redirect to dashboard
        header('Location: /app/todo/member/');
      
      else :      
        // Set session variables
        $_SESSION['error'] = "Incorrect password";
        
        // Redirect to login page
        header('Location: /app/todo/login.php');
      endif;
    
    else :
      // Set session variables
      $_SESSION['error'] = "Invalid login credentials";

      // Redirect to login page
      header('Location: /app/todo/login.php');
    endif;
  endif;

// Check if the form has not been submitted
else:
  // Redirect to login page
  header('Location: /app/todo/login.php');
endif;
?>