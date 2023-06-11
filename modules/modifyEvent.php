<?php

// Include config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Initialize variables
    $event_id = $_POST['event_id'];
    $member_id = $_POST['member_id'];


    if (isset($_POST['done'])) :
        
        // Perform the Update operation
        $sql = "UPDATE events 
                SET situation = 1
                WHERE id = $event_id"; 
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // updation successful
            echo "Row updated successfully!";
            // Redirect to dashboard
            header('Location: /app/todo/coach/member.php?member_id='.$member_id);
        else :
            // updation failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

    elseif (isset($_POST['undo'])) :

        // Perform the Update operation
        $sql = "UPDATE events 
                SET situation = 0
                WHERE id = $event_id"; 
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // updation successful
            echo "Row updated successfully!";
            // Redirect to dashboard
            header('Location: /app/todo/coach/member.php?member_id='.$member_id);
        else :
            // updation failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

    elseif (isset($_POST['delete'])) :

        // Deleting events from the events table.
        $sql = "DELETE FROM events WHERE id = $event_id AND user_id =$member_id"; 
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // Deletion successful
            echo "Row updated successfully!";
            // Redirect to dashboard
            header('Location: /app/todo/coach/member.php?member_id='.$member_id);
        else :
            // Deletion failed
            echo "Error update row: " . mysqli_error($conn);
        endif;
    
    elseif (isset($_POST['modify'])) :

        $title = $_POST['title'];
        $description = $_POST['description'];

        // Perform the Update operation
        $sql = "UPDATE events SET title = '$title', description = '$description'  WHERE id = $event_id";
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // updation successful
            echo "Row updated successfully!";
            // Redirect to dashboard
            header('Location: /app/todo/coach/member.php?member_id='.$member_id);
        else :
            // updation failed
            echo "Error update row: " . mysqli_error($conn);
        endif;


    elseif (isset($_POST['edit'])) :

        header('Location: /app/todo/coach/event.php?event_id='.$event_id);

    endif;
endif;


?>