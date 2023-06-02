<?php

// Require config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    
    //Initialize variables
    $type= $_SESSION['type'];
    

    /* 
    * Check type user
    * Each type of users should be 
    * Able to do different actions
    * in Profile page.
    */

    // 01. Check If the user is a MEMBER
    if ($type == 'member') :

        $user_id = $_POST['user_id'];
        $coach_id = $_POST['coach_id'];

        // Check if delete form is submitted
        if (isset($_POST['delete'])) :

            // Perform the delete operation

            /*
            * Delete member profile from system need to:
            * 1- Delete all events that are below to this member,
            *    and this coach from the events table.
            * 2- Delete member from user table.
            */

            // Deleting events from the events table.
            $event_sql = "DELETE FROM events WHERE user_id = $user_id AND coach_id =$coach_id"; 
            
            // Execute the query
            $event_result = mysqli_query($conn, $event_sql);
            
            // Check if the query was successful
            if ($event_result) :

                // Check the number of affected rows
                $deletedEvents = mysqli_affected_rows($conn);

                // Deletion successful
                echo "Successfully deleted $deletedEvents event(s) for member with ID: $user_id";
                
            else :
                // Deletion failed
                echo "Error deleting row: " . mysqli_error($conn);

            endif;

            // Delete member from user table
            $member_sql = "DELETE FROM users WHERE user_id = $user_id AND coach_id = $coach_id"; 
            
            // Execute the query
            $member_result = mysqli_query($conn, $member_sql);

            // Check if the query was successful
            if ($member_result) :
                // Check the number of affected rows
                $deletedMembers = mysqli_affected_rows($conn);

                if ($deletedMembers > 0) :
                    echo "Successfully deleted member with ID: $user_id";
                else :
                    echo "No member found with ID: $user_id";
                endif;

            else :
                // Query execution failed
                echo "Error: " . mysqli_error($conn);
            endif;

            // Close the database connection
            mysqli_close($conn);
            // Redirect to Logingout
            header('Location: /auth/signout.php');

        // Check if edit form is submitted
        elseif (isset($_POST['edit'])) :

            // Perform the edit operation

            /*
            * Edit member profile in system need to:
            * 1- Check if mobile number or password or both need to change
            * 2- Get new value of password/mobile number
            * 3- Update member in user table.
            */
            
            // Initialize variables
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            
            // Password Hashing
            $hash = password_hash($password, PASSWORD_DEFAULT); 

            // Checking if just the mobile number will change
            if (isset($mobile)) :

                // Perform the Update operation
                $sql = "UPDATE users 
                SET mobile = '$mobile'
                WHERE user_id = $user_id AND coach_id = $coach_id";

            // Checking if just the password will change
            elseif (isset($password)) :

                // Perform the Update operation
                $sql = "UPDATE users 
                SET password = '$password'
                WHERE user_id = $user_id AND coach_id = $coach_id";

            // Checking if both will change
            elseif (isset($mobile) && isset($password)) :                       

                // Perform the Update operation
                $sql = "UPDATE users 
                        SET password = '$hash', mobile = '$mobile'
                        WHERE user_id = $user_id AND coach_id = $coach_id";
            
            endif;

            // Execute the query
            $result = mysqli_query($conn, $sql);

            if ($result) :
                // Deletion successful
                $_SESSION['member_success'] = "Row updated successfully!";
            else :
                // Deletion failed
                echo "Error update row: " . mysqli_error($conn);
            endif;

            // Close the database connection
            mysqli_close($conn);
            // Redirect the member to dashboard
            header('Location: /app/todo/profile.php?user_id='.$user_id);
        
        endif;

    
    // If the user is a coach
    elseif ($type == 'coach') :

        $coach_id = $_POST['user_id'];

        // Check if delete form is submitted
        if (isset($_POST['delete'])) :

            // Perform the delete operation

            /*
            * Delete Coach profile from system need to:
            * 1- Delete all events that are below to members WHO 
            *    have this coach from the events table.
            * 2- Delete all members who below to cocah profile in 
            *    from users table.
            * 2- Delete coach from coaches table.
            */

            // Deleting events from the events table.
            $event_sql = "DELETE FROM events WHERE coach_id =$coach_id"; 
            
            // Execute the query
            $event_result = mysqli_query($conn, $event_sql);
            
            // Check if the query was successful
            if ($event_result) :

                // Check the number of affected rows
                $deletedEvents = mysqli_affected_rows($conn);

                // Deletion successful
                echo "Successfully deleted $deletedEvents event(s) for member with ID: $coach_id";
                
            else :
                // Deletion failed
                echo "Error deleting row: " . mysqli_error($conn);

            endif;

            // Delete member from users table
            $member_sql = "DELETE FROM users WHERE coach_id = $coach_id"; 
            
            // Execute the query
            $member_result = mysqli_query($conn, $member_sql);

            // Check if the query was successful
            if ($member_result) :
                // Check the number of affected rows
                $deletedMembers = mysqli_affected_rows($conn);

                if ($deletedMembers > 0) :
                    echo "Successfully deleted member with ID: $coach_id";
                else :
                    echo "No member found with ID: $coach_id";
                endif;

            else :
                // Query execution failed
                echo "Error: " . mysqli_error($conn);
            endif;

            // Delete coach from coaches table
            $coach_sql = "DELETE FROM coaches WHERE id = $coach_id"; 
            
            // Execute the query
            $coach_result = mysqli_query($conn, $coach_sql);

            // Check if the query was successful
            if ($coach_result) :
                // Check the number of affected rows
                $deletedCoach = mysqli_affected_rows($conn);

                if ($deletedCoach > 0) :
                    echo "Successfully deleted coach with ID: $coach_id";
                else :
                    echo "No coach found with ID: $coach_id";
                endif;

            else :
                // Query execution failed
                echo "Error: " . mysqli_error($conn);
            endif;

            // Close the database connection
            mysqli_close($conn);
            // Redirect to Logingout
            header('Location: /auth/signout.php');

        // Check if edit form is submitted
        elseif (isset($_POST['edit'])) :
            // Perform the edit operation

            /*
            * Edit coach profile in system need to:
            * 1- Check if mobile number or password or both need to change
            * 2- Get new value of password/mobile number
            * 3- Update member in user table.
            */
            
            // Initialize variables
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            
            // Password Hashing
            $hash = password_hash($password, PASSWORD_DEFAULT); 

            // Checking if just the mobile number will change
            if (isset($mobile)) :

                // Perform the Update operation
                $sql = "UPDATE coaches 
                SET mobile = '$mobile'
                WHERE id = $coach_id";

            // Checking if just the password will change
            elseif (isset($password)) :

                // Perform the Update operation
                $sql = "UPDATE coaches 
                SET password = '$password'
                WHERE id = $coach_id";

            // Checking if both will change
            elseif (isset($mobile) && isset($password)) :                       

                // Perform the Update operation
                $sql = "UPDATE coaches 
                        SET password = '$hash', mobile = '$mobile'
                        WHERE id = $coach_id";
            
            endif;

            // Execute the query
            $result = mysqli_query($conn, $sql);

            if ($result) :
                // Deletion successful
                $_SESSION['coach_success'] = "Row updated successfully!";
            else :
                // Deletion failed
                echo "Error update row: " . mysqli_error($conn);
            endif;

            // Close the database connection
            mysqli_close($conn);
            // Redirect the member to dashboard
            header('Location: /app/todo/profile.php?user_id='.$coach_id);
        
        endif;        
    endif;
endif;