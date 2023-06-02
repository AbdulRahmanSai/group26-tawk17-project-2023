<?php

// Require config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';


// Get session variables
$username = $_SESSION['username'];

// Get Admin info
$admin_sql = "SELECT * FROM admins WHERE username='$username'";
$admin_result = mysqli_query($conn, $admin_sql);
$admin_row = mysqli_fetch_assoc($admin_result);

// Get admin variables
$firstname = $admin_row['firstname'];
$lastname = $admin_row['lastname'];
$email = $admin_row['email'];

// Get coaches
$sql = "SELECT * FROM coaches";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
    <header class="header">
      <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
    </header>
    <main class="container">
      <section class="title">
        <h1>Admin dashboard</h2>
      </section>
      <section class="profile">
        <div>
          <h3><?php echo $firstname ." ". $lastname; ?></h3>
          <p>Email: <?php echo $email; ?></p>
        </div>
        <img src="../img/profilepicture.jpg" height="240px" alt="<?php echo $firstname ." ". $lastname; ?> profile picture">
      </section>
      <section class="coaches">
        <h2>Coaches</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Creation date</th>
              <th>Status</th>
              <th>Membership<br>Type</th>
              <th>Membership<br>Start date</th>
              <th>Membership<br>End date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>          
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td>
                  <a href="mailto:<?php echo $row['email']; ?>"
                    title="<?php echo $row['firstname']." ".$row['lastname']; ?> Email">
                    <?php echo $row['email']; ?>
                  </a>
                </td>
                <td><?php echo $row['mobile']; ?></th>
                <td><?php echo $row['createdate']; ?></th>
                <td><?php echo $row['status']; ?></th>
                <td><?php echo $row['type']; ?></th>
                <td><?php echo $row['startdate']; ?></th>
                <td><?php echo $row['enddate']; ?></th>
                <td>
                  <form action="/modules/modifyCoach.php" method="post" class="membersActions">
                    <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                    <input type="hidden" name="coach_id" value="<?php echo $row['coach_id']; ?>">
                    <input type='submit' 
                      name="<?php 
                        if ($row['status']=="inactive") : echo "active"; 
                        elseif ($row['status']=="active") : echo "inactive";
                        endif;
                        ?>" 
                      value="<?php 
                        if ($row['status']=="inactive") : echo "Active"; 
                        elseif ($row['status']=="active") : echo "Inactive"; 
                        endif;
                    ?>">
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
    <footer class="footer">
      <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/footer.php'; ?>
    </footer>
</body>
</html>