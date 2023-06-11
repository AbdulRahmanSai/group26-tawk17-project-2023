<?php

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

/* User:Member Signup logic */

// Include config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    $isCoacRegister = $_POST['isCoacRegister'];

    /*
    * Checking submitting user if a Coach
    * OR member
    */
    if ($isCoacRegister == true) :

        // Initialize variables
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST["cpassword"];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $city = $_POST['city'];
        $timezone = $_POST['timezone'];
        $status = "inactive";
        $type = "standard";
        $startdate = date('Y-m-d');
        $enddate = date('Y-m-d', strtotime('+1 year'));

        /* Uploading profile picture */
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profilepicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) :
            $check = getimagesize($_FILES["profilepicture"]["tmp_name"]);
            if($check !== false) :
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            elseif ($check == true) :
                echo "File is not an image.";
                //$_SESSION['coach_error'] = "File is not an image.";
                $uploadOk = 0;
            endif;
        endif;
        
        // Check file size
        if ($profilepicture["size"] > 500000) :
            echo "Sorry, your file is too large.";
            //$_SESSION['coach_error'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        endif;

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg") :
            echo "Sorry, only JPG files are allowed.";
            //$_SESSION['coach_error'] = "Sorry, only JPG files are allowed.";
            $uploadOk = 0;
        endif;

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) :
            echo "Sorry, your file was not uploaded.";
            //$_SESSION['coach_error'] = "Sorry, your file was not uploaded.";
        
        // if everything is ok, try to upload file
        elseif ($uploadOk == 1) :
            if (move_uploaded_file($_FILES['profilepicture']["tmp_name"], $targetFile)) {
                echo "The file ". basename($_FILES['profilepicture']['name']). " has been uploaded.";
            }
            else {
                echo "Sorry, there was an error uploading your file.";
                //$_SESSION['coach_error'] = "Sorry, there was an error uploading your file.";
            }
        endif;

        /* 
        * Coach Validates
        */

        /*
        * Checking*
        * 1- Checking if the Coach username or email is used in the system
        * 2- If the password is confirmed
        * 3- Profile picture is uploaded, NOT READY!
        *
        * Then add the coach to database
        */

        $sql = "SELECT username, email FROM coaches WHERE username='$username' AND email='$email'";
        $result = mysqli_query($conn, $sql);

        /* Validate Coach availability */
        
        // If the Coach username or email is used in the system
        if (mysqli_num_rows($result) > 0) :        
            $_SESSION['coach_error'] = "The Coach username or email is already in the system!";
            header('Location: /app/todo/login.php');
            
        // The coach is not avalible on the system
        else :
            
            // Check if the password is confirmed
            if($password == $cpassword) :

                // Password Hashing
                $hash = password_hash($password, PASSWORD_DEFAULT);

                /* Add coach to datebase */
                $sql = "INSERT INTO coaches (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `mobile`, `gender`, `birthday`, `city`, `timezone`, `createdate`, `status`, `type`, `startdate`, `enddate`, `profileimage`)
                        VALUES (NULL, '$username', '$hash', '$firstname', '$lastname', '$email', '$mobile', '$gender', '$birthday', '$city', '$timezone', current_timestamp(), '$status', '$type', '$startdate', '$enddate', '')";
                    
                if ($conn->query($sql) === TRUE) :
                    echo "Coach created successfully";
                    // Set session variable
                    $_SESSION['success'] = "Coach created successfully";
                    header('Location: /app/todo/login.php');
                else :
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    // Set session variable
                    $_SESSION['coach_error'] = true;
                endif;
            endif;
        endif;

    // If the user is a member
    elseif ($isCoacRegister == false):

        // Initialize variables
        $coach_id = $_POST['coachcode'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST["cpassword"];
        $role = "member";
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $city = $_POST['city'];
        $timezone = $_POST['timezone'];
        $status = "active";
        $startdate = date('Y-m-d');
        $enddate = date('Y-m-d', strtotime('+1 year'));

        /* 
        * Coach Validates
        * Check coach availability and sistuation 
        */

        $coach_sql = "SELECT id, status FROM coaches WHERE id='$coach_id'";
        $result = mysqli_query($conn, $coach_sql);

        /* Validate coach availability */
        // If the coach is avalible on the system

            
        // Fetch the coach data
        $row = mysqli_fetch_assoc($result);

        // If the coach is avalible in the system
        if ($row['id'] == $coach_id) :
                
            /* Validate coach sistuation */

            // If the coach is not active!
            if (($row['status'] == "inactive")) :

                $_SESSION['member_error'] = "Coach profile is not active yet!";
                header('Location: /app/todo/register.php');
                
            // If the coach is active
            elseif (($row['status'] == "active")) : 

                // Check if the password is confirmed
                if(($password == $cpassword)) :

                    // Password Hashing
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    // Add user to datebase
                    $user_sql = "INSERT INTO users (`user_id`, `coach_id`, `username`, `password`, `role`, `firstname`, `lastname`, `email`, `mobile`, `gender`, `birthday`, `city`, `timezone`, `createdate`, `status`, `startdate`, `enddate`)
                            VALUES (NULL, '$coach_id', '$username', '$hash', '$role', '$firstname', '$lastname', '$email', '$mobile', '$gender', '$birthday', '$city', '$timezone', current_timestamp(), '$status', '$startdate', '$enddate')";
                                
                    if ($conn->query($user_sql) === TRUE) :
                        // Set session variable
                        $_SESSION['member_success'] = "User created successfully";
                    else :
                        echo "Error: " . $user_sql . "<br>" . $conn->error;
                        // Set session variable
                        $_SESSION['member_error'] = "There is an error with adding a member, try again!";
                        // Redirect to register page
                        header('Location: /app/todo/login.php');
                    endif;
                endif;
            endif;
            
        // The coach is not avalible on the system
        elseif ($row['id'] != $coach_id) :
            $_SESSION['member_error'] = "Coach profile is not avalible on the system!";
            $member_error = $_SESSION["member_error"]; 
            // Redirect to register page
            header('Location: /app/todo/register.php');
        endif;

    endif;

// Check if the form has not been submitted
else :
    // Redirect to Login page
    header('Location: /app/todo/register.php');

endif;
?>