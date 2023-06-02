<?php

// Include config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Initialize variables
$member_id = $_GET['user_id'];

// For upating the event
$sql = "SELECT * FROM users WHERE user_id=$member_id";
// Execute the query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member edit page</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
    </header>
    <main class="container">
        <section class="title"> 
            <h1>Member modiftion</h1>
        </section>
        <section class="">
        <div>
            <?php           
            /* Updating a spesific member by user_id */
            while($row = mysqli_fetch_assoc($result)) :             
                if ($row['user_id']=$member_id):
                ?>
                    <h3><?php echo $row['user_id']. ". ". $row['firstname']." ".$row['lastname']; ?></h3>
                    <form action="/modules/modifyMember.php" method="post">
                        <div class="formRow">
                            <div class="formInput">
                            <label for="startdate">Membership etart date: </label>
                            <input type="date" name="startdate" value="<?php echo $row['startdate'];?>" required>
                            </div>
                            <div class="formInput">
                            <label for="enddate">Membership end date: </label>
                            <input type="date" name="enddate" value="<?php echo $row['enddate'];?>" required>
                            </div>
                        </div>
                        <div class="formRow">
                            <div class="formInput">
                            <input type="hidden" name ="member_id" value="<?php echo $row['user_id']; ?>">
                            <input type="hidden" name ="coach_id" value="<?php echo $row['coach_id']; ?>">
                            <input type='submit' name='modify' value="Edit">
                            <button type ="button" onclick="document.location='/app/todo/coach/'">Cancel</button>
                            </div>          
                        </div>
                    </form>
                <?php 
                endif;
            endwhile; ?>
        </div>      
        </section>
    </main>  
    <footer class="footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates//footer.php'; ?>
    </footer>
</body>
</html>