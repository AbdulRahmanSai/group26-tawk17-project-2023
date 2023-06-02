<?php
// Include config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';


// Get session variables
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$coach_id = $_SESSION['coach_id'];
$user_type = $_SESSION['type'];

// Get member info
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// get member variables
$firstname = $row['firstname'];
$lastname = $row['lastname'];

// Get coach info
$coach_sql = "SELECT * FROM coaches WHERE id='$coach_id'";
$coach_result = mysqli_query($conn, $coach_sql);
$coach_row = mysqli_fetch_assoc($coach_result);

// Get event info
$event_sql = "SELECT * FROM events 
              WHERE coach_id='$coach_id'
              AND user_id = $user_id";
$event_result = mysqli_query($conn, $event_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member dashboard</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
  <header class="header">
    <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
  </header>
  <main class="container">
    <section class="title">
      <h1><a href="/app/todo/profile.php?user_id=<?php echo $user_id; ?>"><?php echo $firstname ." ". $lastname; ?></a>'s dashboard</h2>
    </section>
    <section class="events">
      <h2>Events</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Situation</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($event_row = mysqli_fetch_assoc($event_result)) : ?>
            <tr>
              <td><?php echo $event_row['id']; ?></td>
              <td><?php echo $event_row['title']; ?></td>
              <td><?php echo $event_row['description']; ?></td>
              <td><?php if ($event_row['situation']==0) : echo "Waiting"; else: echo "Done"; endif; ?></td>
              <td><?php echo $event_row['date']; ?></td>
              <td>
                <form action="/modules/modifyEvent.php" method="post">
                  <input type="hidden" name="event_id" value="<?php echo $event_row['id']; ?>">
                  <input type="submit" name="<?php if($event_row['situation']==0) : echo 'done'; else: echo 'undo'; endif; ?>" value="<?php if($event_row['situation']==0) : echo 'Done'; else: echo 'Undo'; endif; ?>">
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </main>
  <footer class="footer">
    <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates//footer.php'; ?>
  </footer>
</body>
</html>