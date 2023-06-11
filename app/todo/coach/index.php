<?php
// Require config file
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Require Login Validation
require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/validateLogin.php';

// Get session variables
$coach_id = $_SESSION['id'];
$username = $_SESSION['username'];
$user_type = $_SESSION['type'];

// Get Coach info
$coach_sql = "SELECT * FROM coaches WHERE id='$coach_id'";
$coach_result = mysqli_query($conn, $coach_sql);
$coach_row = mysqli_fetch_assoc($coach_result);

// Get Coach variables
$firstname = $coach_row['firstname'];
$lastname = $coach_row['lastname'];

// Get trainees
$sql = "SELECT * FROM users WHERE coach_id='$coach_id'";
$result = mysqli_query($conn, $sql);

// For upating the trainees
$change_sql = "SELECT * FROM users WHERE coach_id='$id'";
// Execute the query
$change_result = mysqli_query($conn, $change_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $firstname; ?>' coach dashboard</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/app/assets/css/style.css">
</head>
<body>
  <header class="header">
    <?php include $_SERVER['DOCUMENT_ROOT'] .'/app/templates/header.php'; ?>
  </header>
  <main class="container">

    <section class="title">
      <h1><?php echo $firstname.' '.$lastname; ?>'s dashboard</h2>
    </section>   

    <section class="trainees">
      <h2>Trainees</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Status</th>
            <th>Membership<br>End date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>          
          <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td>
                <a href="member.php?member_id=<?php echo $row['user_id']; ?>"
                  title="<?php echo $row['firstname']." ".$row['lastname']; ?> ID">
                  <?php echo $row['user_id']; ?>
                </a>
              </td>
              <td>
                <a href="member.php?member_id=<?php echo $row['user_id']; ?>"
                  title="<?php echo $row['firstname'].' '.$row['lastname']; ?>">
                  <?php echo $row['firstname'].' '. $row['lastname']; ?>
                </a>
              </td>
              <td>
                <a href="mailto:<?php echo $row['email']; ?>"
                  title="<?php echo $row['firstname']." ".$row['lastname']; ?> Email">
                  <?php echo $row['email']; ?>
                </a>
              </td>
              <td>
                <a href="tel:<?php echo $row['mobile']; ?>"
                  title="<?php echo $row['firstname']." ".$row['lastname']; ?> mobile number">
                  <?php echo $row['mobile']; ?>
                </a>
              </td>
              <td><?php echo $row['gender']; ?></td>
              <td>
                <?php 
                $birthday = $row['birthday'];
                $age = (date('Y') - date('Y',strtotime($birthday)));
                echo $age; 
                ?>
              </td>
              <td>
                <?php 
                if ($row['status'] == 'active') :
                  echo '<strong style="color: green">'.$row['status']. '</strong>';
                elseif ($row['status'] == 'inactive') :
                    echo '<strong style="color: red">'.$row['status']. '</strong>';
                endif;
                ?>
              </td>
              <td><?php echo $row['enddate']; ?></td>
              <td>
                <form action="/modules/modifyMember.php" method="post" class="membersActions">
                  <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                  <input type="hidden" name="member_id" value="<?php echo $row['user_id']; ?>">
                  <input type="hidden" name="coach_id" value="<?php echo $row['coach_id']; ?>">
                  <input type="submit" name="edit" value="Edit">
                  <input type='submit' name='delete' value="Delete">
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

  <!-- Start JS scripts -->
  <script>
    function openEditForm() { document.getElementById("editPopupForm").style.display = "block"; }
    function closeEditForm() { document.getElementById("editPopupForm").style.display = "none"; }
  </script>
  <!-- End JS scripts -->

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>