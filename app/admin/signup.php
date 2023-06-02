<?php
/* User:Admin Signup logic */

// Require config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Initialize variables
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST["cpassword"];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $regcode = $_POST['regcode'];

    /* 
    * Admin Validates
    */

    $sql = "SELECT username, email FROM admins WHERE username='$username' AND email='$email'";
    $result = mysqli_query($conn, $sql);

    /* Validate Admin availability */
    
    // If the admin username of email is avalible on the system
    if (mysqli_num_rows($result) > 0) :        
        $_SESSION['admin_error'] = "The admin username or email is already in the system!";
        header('Location: /admin/login.php');
        
    // The admin is not avalible on the system
    else :

        /* Validate Admin registration */
            
        // The registration code is wrong.
        if ( $regcode !== "helloworld" ) :
            $_SESSION['admin_error'] = "The registration code you entered is wrong!";
            header('Location: /admin/login.php');
        
        // Check registration code
        elseif ( $regcode === "helloworld" ) :

            // Check if the password is confirmed
            if ( $password == $cpassword ) :

                // Password Hashing
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Add user to datebase
                $sql = "INSERT INTO admins (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `createdate`)
                        VALUES (NULL, '$username', '$hash', '$firstname', '$lastname', '$email', current_timestamp())";

                if ($conn->query($sql) === TRUE) :
                    // Set session variable
                    $_SESSION['admin_success'] = "Admin created successfully";
                    header('Location: /admin/login.php');
                else :
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    // Set session variable
                    $_SESSION['admin_error'] = true;
                endif;

            // the password is not confirmed!
            else :
                // Set session variable
                $_SESSION['admin_error'] = "The password is not confirmed!";

            endif;        
        endif;
    endif;
endif;  

//$_SESSION['user_id'] = mysqli_insert_id($conn);

// Redirect to dashboard
header('Location: /admin/register.php');
?>

