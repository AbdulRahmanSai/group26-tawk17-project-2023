<?php 

// Require config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

// Get session variables
$user_id = $_GET['user_id'];
$loaged_coach_id = $_SESSION['id'];
$loged_user_id = $_SESSION['user_id'];
$user_type = $_SESSION['type'];

// Checking the type of user
if ($user_type == 'member') :
    // Checking profile for the right user
    if ($user_id == $loged_user_id) :

        // Get user from DB
        $sql = "SELECT * FROM users WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Get user data
        $coach_id = $row['coach_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $mobile = $row['mobile'];
        $email = $row['email'];
        $createdate = $row['createdate'];
        $status = $row['status'];
        $startdate = $row['startdate'];
        $enddate = $row['enddate'];

    // Wrong user
    else :
        header('location: /403.php');
    endif;

elseif ($user_type == 'coach') :
    // Checking profile for the right user
    if ($user_id == $loaged_coach_id) :

        // Get user from DB
        $sql = "SELECT * FROM coaches WHERE id='$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Get user data
        $coach_id = $row['coach_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $mobile = $row['mobile'];
        $email = $row['email'];
        $createdate = $row['createdate'];
        $status = $row['status'];
        $startdate = $row['startdate'];
        $enddate = $row['enddate'];

    // Wrong user
    else :
        header('location: /403.php');
    endif;
endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include '../../app/templates/header.php'; ?>
    </header>
    <main class="container">
        <section class="title">
            <h1><?php echo $row['firstname']; ?>'s Profile</h1>
            <p>Membership creation date: <strong><?php echo $createdate; ?></strong></p>
            <?php
            if ($status == 'active') :
                echo '<p>Membership status: <strong style="color: green">'. $status. '</strong></p>';
            elseif ($status == 'inactive') :
                echo '<p>Membership status: <strong style="color: red">'. $status. '</strong></p>';
            endif;
        ?>
        </section>
        <section class="profile">
            <form action="/modules/modifyProfile.php" method="post">
                <div class="formRow">
                    <div class="formInput">
                        <label for="firstname">First name</label>
                        <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" disabled>
                    </div>
                    <div class="formInput">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" disabled>
                    </div>
                </div>
                <div class="formRow">
                    <div class="formInput">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" disabled>
                    </div>
                    <div class="formInput">
                        <label for="mobile">Mobile number</label>
                        <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>">
                    </div>
                </div>
                <div class="formRow">
                    <div class="formInput">
                        <label for="username">Username</label>
                        <input type="text" name="username"  value="<?php echo $row['username']; ?>" disabled>
                    </div>
                    <div class="formInput">
                        <label for="password">Password:</label>
                        <input type="password" name="password">
                    </div>
                </div>
                <div class="formRow">
                    <div class="formInput">
                        <label for="username">Membership start date</label>
                        <input type="text" name="startdate"  value="<?php echo $row['startdate']; ?>" disabled>
                    </div>
                    <div class="formInput">
                        <label for="username">Membership end date</label>
                        <input type="text" name="startdate"  value="<?php echo $row['enddate']; ?>" disabled>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="coach_id" value="<?php echo $coach_id; ?>">
                <input type="hidden" name="type" value="member">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="delete" value="Delete">
                <button type ="button" onclick="document.location='<?php if ($user_type === 'member') : echo 'member/index.php'; elseif ($user_type === 'coach') : echo 'coach/index.php'; endif; ?>'">Cancel</button>
            </form>
            <div class="profieImage">
                <img src="" alt="<?php echo $row['firstname']." ".$row['lastname']." pofile image"; ?>" height="320px">
            </div>
        </section>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/validateErrors.php'; ?>
    </main>
    <footer class="footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/app/templates//footer.php'; ?>
    </footer>    
</body>
</html>