<?php

// Include config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Initialize variables
$title = $_POST['title'];
$description = $_POST['description'];
$coach_id = $_POST['coach_id']; echo $coach_id;
$member_id = $_POST['user_id']; echo $member_id;

// Add the event
$sql = "INSERT INTO events (`id`, `user_id`, `coach_id`, `title`, `description`, `situation`, `date`)
        VALUES (NULL, '$member_id', '$coach_id', '$title', '$description', 0, current_timestamp())";
        
$result = mysqli_query($conn, $sql);
 
// Redirect to dashboard
header('Location: /app/todo/coach/member.php?member_id='.$member_id);

?>