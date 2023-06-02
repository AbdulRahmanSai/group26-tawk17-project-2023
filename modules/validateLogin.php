<?php

// Start session
session_start();

// get current page file name
$pageName = basename($_SERVER['PHP_SELF']);

// Then the user is not logged in    
if(!isset($_SESSION["loggedin"])) :    

    // If the user tries to access the login/register page 
    if($pageName == 'login.php' || $pageName == 'register.php') :
        return;

    // Then redirect the user to login page
    else: 
        // redirect the user to the login page
        header('Location: /app/todo/login.php');

    endif;

// check if the user is already logged in
elseif(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) :

    // check if the user is a Admin
    if(isset($_SESSION["type"]) && $_SESSION["type"] === 'admin') :

        // If the user is in admin page 
        if ($pageName == 'index.php') :
            return;

        // If the Admin tries to access the profile page 
        elseif ($pageName != 'profile.php') :
        
            // redirect the member to the Admin dashboard
            header('Location: /app/admin/');
        
        endif;

    // check if the user is a Coach
    elseif(isset($_SESSION["type"]) && $_SESSION["type"] === 'coach') :

        // If the user is in member page 
        if ($pageName == 'index.php' || $pageName = 'member.php') :
            return;
            
        // If the user tries to access the profile page 
        elseif ($pageName != 'profile.php') :
            
            // redirect the coach to the coach dashboard
            header('Location: /app/todo/coach/');       
        
        endif;

    // check if the user is a Member
    elseif(isset($_SESSION["type"]) && $_SESSION["type"] === 'member') :

        // If the user is in member page 
        if ($pageName == 'index.php') :
            return;

        // If the user tries to access the profile page 
        elseif ($pageName != 'profile.php') :
            
            // redirect the member to the member dashboard
            header('Location: /app/todo/member/');       
        
        endif;           
    
    endif;    

endif;

?>