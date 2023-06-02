<?php

// Include config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Initialize variables
$event_id = $_GET['event_id'];

// For upating the event
$sql = "SELECT * FROM events WHERE id=$event_id";
// Execute the query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event edit page</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
        <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
    </header>
    <main class="container">
        <section class="title"> 
            <h1>Event modiftion</h1>
        </section>
        <section class="">
        <div>
            <?php           
            /* Updating a spesific member by user_id */
            while($row = mysqli_fetch_assoc($result)) :             
                if ($row['id']=$event_id):
                ?>
                    <form action="/modules/modifyEvent.php" method="post">
                    <div class="formRow">
                        <div class="formInput">
                        <label for="title">Title: </label>
                        <input type="text" name="title" value="<?php echo $row['title'];?>" required>
                        </div>
                        <div class="formInput">
                        <label for="description">Description: </label>
                        <input type="text" name="description" value="<?php echo $row['description'];?>" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="formInput">
                        <input type="hidden" name ="event_id" value="<?php echo $row['id']; ?>">    
                        <input type="hidden" name ="member_id" value="<?php echo $row['user_id']; ?>">
                        <input type="hidden" name ="coach_id" value="<?php echo $row['coach_id']; ?>">
                        <input type='submit' name='modify' value="Edit">
                        <button type ="button" onclick="document.location='/app/todo/coach/member.php?member_id=<?php echo $row['user_id']; ?>'">Cancel</button>
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