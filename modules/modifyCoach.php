<?php

// Include config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Initialize variables
    $coach_id = $_POST['coach_id'];
    $status = $_POST['status'];
    
    // Check if status (ACTIVE) form is submitted
    if (isset($_POST['inactive'])) :
        
        // Perform the Update operation
        $sql = "UPDATE coaches SET status = 'inactive' WHERE id = '$coach_id'";
        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // Upadte successful
            echo "Row updated successfully!";
        else :
            // Upadte failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

        // Close the database connection
        mysqli_close($conn);
        // Redirect to dashboard
        header('Location: /app/admin/');

    // Check if status (INACTIVE) form is submitted
    elseif (isset($_POST['active'])) :
        
        // Perform the Update operation
        $sql = "UPDATE coaches SET status = 'active' WHERE id = '$coach_id'"; 
        // Execute the query                
        $result = mysqli_query($conn, $sql);

        if ($result) :
            // update successful
            echo "Row updated successfully!";            
        else :
            // update failed
            echo "Error update row: " . mysqli_error($conn);
        endif;

        // Close the database connection
        mysqli_close($conn);
        // Redirect to dashboard
        header('Location: /app/admin/'); 
    endif;  

endif;

?>