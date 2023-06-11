<?php
// Include config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

// Get session variables
$coach_id = $_SESSION['id'];
$member_id = $_GET['member_id'];

// Get member data

$member_sql = "SELECT * FROM users WHERE user_id='$member_id' AND coach_id='$coach_id'";
$member_result = mysqli_query($conn, $member_sql);

// Check the right user
if (mysqli_num_rows($member_result) > 0) :
  $member_row = mysqli_fetch_assoc($member_result);

  // Get events list
  $events_sql = "SELECT *
          FROM events
          JOIN users
          ON events.user_id = users.user_id
          WHERE users.user_id = $member_id
          AND events.coach_id = $coach_id";
  // Execute the query
  $events_result = mysqli_query($conn, $events_sql);

// Wrong user
else :
  header('location: /403.php');
endif;


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $member_row['firstname']; ?>'s events dashboard</title>
  <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
  <header class="header">
    <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
  </header>
  <main class="container">
    
    <section class="title"> 
      <h1>Member's events dashboard</h1>
    </section>

    <section class="profile">
      <div>
        <h3>
          <?php echo $member_row['firstname'] ." ". $member_row['lastname']; ?>
        </h3>
        <table>
          <tr>
            <td>
              <strong>Birthday: </strong>
              <?php 
                $birthday = $member_row['birthday'];
                $age = (date('Y') - date('Y',strtotime($birthday)));
                echo $birthday.' ('.$age.')'; 
              ?>
            </td>
            <td>
              <strong>Status: </strong>
              <?php 
              if ($member_row['status'] == 'active') :
                echo '<strong style="color: green">'.$member_row['status']. '</strong>';
              elseif ($member_row['status'] == 'inactive') :
                  echo '<strong style="color: red">'.$member_row['status']. '</strong>';
              endif;
              ?>              
            </td>
          </tr>
          <tr>
            <td>
              <strong>Mobile number: </strong>
              <a href="tel:<?php echo $member_row['mobile']; ?>"
                  title="<?php echo $member_row['firstname'] ." ". $member_row['lastname']; ?> mobile number">
                <?php echo $member_row['mobile']; ?>
              </a>
            </td>
            <td>
              <strong>Joined date: </strong><?php echo $member_row['createdate']; ?>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Email: </strong>
              <a href="mailto:<?php echo $member_row['email']; ?>"
                  title="<?php echo $member_row['firstname'] ." ". $member_row['lastname']; ?> email">
              <?php echo $member_row['email']; ?>
              </a>
            </td>
            <td>
              <strong>Membership start date: </strong><?php echo $member_row['startdate']; ?>
            </td>
          </tr>
          <tr>
            <td>
              <strong>City: </strong><?php echo $member_row['city'].' ('.$member_row['timezone'].')'; ?>
            </td>
            <td>
              <strong>Membership end date: </strong><?php echo $member_row['enddate']; ?>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Current Time: </strong>
              <?php 
              $timezone = $member_row['timezone'];
              $path = "https://timeapi.io/api/Time/current/zone?timeZone=".$timezone;
              $time = file_get_contents($path);
              $response = json_decode($time, true);
              echo $response['time'];
              ?>
            </td>                        
          </tr>
        </table>
      </div>
      <img src="../img/loujain_profilepicture.jpg" height="240px" alt="<?php echo $firstname ." ". $lastname; ?> profile picture">
    </section>

    <section class="events">
      <table>
        <tr>
          <th>ID</th>
          <th>title</th>
          <th>Description</th>
          <th>Situation</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
          
        <?php 
        // Check if there are any rows returned
        if ($events_result->num_rows > 0) :
          while($row = mysqli_fetch_assoc($events_result)) :            
        ?>

        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['title']; ?></td>
          <td><?php echo $row['description']; ?></td>
          <td><?php if ($row['situation']==1) { echo "Done";} else { echo "Waiting"; } ?></td>
          <td><?php echo $row['date']; ?></td>
          <td>
            <form action="/modules/modifyEvent.php" method="post" class="eventsActions">
              <input type="hidden" name ="event_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name ="member_id" value="<?php echo $member_id; ?>">
              <input type="submit" name="edit" value="Edit">
              <input type='submit' name="delete" value="Delete">
              <input type='submit' 
                name="<?php 
                  if ($row['situation']==1) : echo "undo"; 
                  elseif ($row['situation']==0) : echo "done";
                  endif;
                  ?>" 
                value="<?php 
                  if ($row['situation']==1) : echo "Undo";
                  elseif ($row['situation']==0) : echo "Done"; 
                  endif;
              ?>">
            </form>
          </td>
        </tr>
          
        <?php 
          endwhile;
        else :
        ?>
          
        <tr><td>No Events</td></tr>          
        <?php endif; ?>

      </table>
    </section> 

    <section class="addEventsForm">
      <h2>Event registration</h2>    
      <form action="/modules/createEvent.php" method="POST" >
        <div class="formRow">
          <div class="formInput">
            <label for="title">Title</label>
            <input type="text" name="title" required>
          </div>
          <div class="formInput">
            <label for="description">Description</label>
            <input type="text" name="description" required>
          </div>
        </div>
        <input type="hidden" name="coach_id" value="<?php echo $coach_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo $member_id; ?>">
        <input type="submit" value="Add">
      </form>
    </section>
    
  </main>  
  <footer class="footer">
    <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates//footer.php'; ?>
  </footer>

  <!-- Start JS scripts -->
  <script>
    function openEditForm() { document.getElementById("editPopupForm").style.display = "block"; }
    function closeEditForm() { document.getElementById("editPopupForm").style.display = "none"; }
  </script>
  <!-- End JS scripts -->
</body>
</html>