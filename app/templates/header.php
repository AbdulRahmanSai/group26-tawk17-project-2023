<?php
echo '
<nav class="navbar">
    <ul class="pages_links">
        <li><a href="/"><img src="" alt="logo"></a></li>
        <li><a href="#">About URZone</a></li>
        <li><a href="#">Support</a></li>
        <li><a href="#">Contact Us</a></li>
    </ul>
    <ul class="profile_links">
';

if ( isset($_SESSION['loggedin']) ) : 
    if ( $_SESSION['type'] === "coach" ) : 
        echo '<li><a href="/app/todo/profile.php?user_id='.$coach_id.'" title="Edit Coach profile">Edit Profile</a></li>';
    elseif ( $_SESSION['type'] === "member" ) : 
        echo '<li><a href="/app/todo/profile.php?user_id='.$user_id.'" title="Edit Member profile">Edit Profile</a></li>';
    endif;
    
    echo '<li><a href="/auth/signout.php" title="SignOut">Logout</a></li>';
endif; 
echo '
    </ul>
</nav>
';
?>