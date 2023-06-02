<?php 

// Set session variables
$error = $_SESSION["error"];
$member_error = $_SESSION["member_error"];
$success = $_SESSION["success"];
$member_success = $_SESSION["member_success"];

// errors
if (isset($error)) : 
    echo '<p style="color: red;">'. $error.'</p>';
elseif (isset($member_error)) : 
    echo '<p style="color: red;">'. $member_error.'</p>';

// success
elseif (isset($success)) : 
    echo '<p style="color: green;">'.$success.'</p>';
elseif (isset($member_success)) : 
    echo '<p style="color: green;">'.$member_success.'</p>';

endif;
?>