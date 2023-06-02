<?php

// Include config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Initialize variables
    $member_id = $_POST['member_id'];
    $coach_id = $_POST['coach_id'];
    $status = $_POST['status'];


    // Check if the delete form is submitted
    if (isset($_POST['delete'])) :
        
        // Perform the delete operation

        /*
        * Delete member from system need to:
        * 1- Delete all events that are below to this member,
        *    and this coach from the events table.
        * 2- Delete member from user table.
        */

        // Deleting events from the events table.
        $event_sql = "DELETE FROM events WHERE user_id = $member_id AND coach_id =$coach_id"; 
        
        // Execute the query
        $event_result = mysqli_query($conn, $event_sql);
        
        // Check if the query was successful
        if ($event_result) :

            // Check the number of affected rows
            $deletedEvents = mysqli_affected_rows($conn);

            // Deletion successful
            echo "Successfully deleted $deletedEvents event(s) for member with ID: $member_id";
            
        else :
            // Deletion failed
            echo "Error deleting row: " . mysqli_error($conn);

        endif;

        // Delete member from user table
        $member_sql = "DELETE FROM users WHERE user_id = $member_id AND coach_id = $coach_id"; 
        
        // Execute the query
        $member_result = mysqli_query($conn, $member_sql);

        // Check if the query was successful
        if ($member_result) :
            // Check the number of affected rows
            $deletedMembers = mysqli_affected_rows($conn);

            if ($deletedMembers > 0) :
                echo "Successfully deleted member with ID: $member_id";
            else :
                echo "No member found with ID: $member_id";
            endif;

        else :
            // Query execution failed
            echo "Error: " . mysqli_error($conn);
        endif;

        // Close the database connection
        mysqli_close($conn);
        // Redirect to dashboard
        header('Location: /app/todo/coach/');

    // Check if status (ACTIVE) form is submitted
    elseif (isset($_POST['inactive'])) :
        
        // Perform the Update operation
        $sql = "UPDATE users 
                SET status = 'inactive'
                WHERE user_id = $member_id
                AND coach_id = $coach_id";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // Deletion successful
            echo "Row updated successfully!";
        else :
            // Deletion failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

        // Close the database connection
        mysqli_close($conn);
        // Redirect to dashboard
        header('Location: /app/todo/coach/');

    // Check if status (INACTIVE) form is submitted
    elseif (isset($_POST['active'])) :
        
        // Perform the Update operation
        $sql = "UPDATE users 
                SET status = 'active'
                WHERE user_id = $member_id
                AND coach_id = $coach_id"; 

        // Execute the query                
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // Deletion successful
            echo "Row updated successfully!";            
        else :
            // Deletion failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

        // Close the database connection
        mysqli_close($conn);
        // Redirect to dashboard
        header('Location: /app/todo/coach/');

    elseif (isset($_POST['modify'])) :

        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        echo $member_id;

        // Perform the Update operation
        $sql = "UPDATE users SET startdate = '$startdate', enddate = '$enddate'  WHERE user_id = $member_id";
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // updation successful
            echo "Row updated successfully!";
            // Redirect to dashboard
            header('Location: /app/todo/coach/');
        else :
            // updation failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

    // Check if edit member form is submitted
    elseif (isset($_POST['edit'])) :

        header('Location: /app/todo/coach/memberProfile.php?user_id='.$member_id);

    endif;

endif;

?>