  <?php
  session_start();
  echo $_SESSION['customerid'];
  echo $_SESSION['Userid'];
?>
<!DOCTYPE html>
<html>
<title>Account</title>

<style>
br {
   display: block;
   margin: 17px 0;
}
</style>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php include 'header_user.php' ?>
<?php include 'usersidebar.php' ?>

<div class="w3-container">
  <p>The w3-container class can be used to display headers.</p>
</div>




</body>
</html>