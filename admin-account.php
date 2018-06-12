<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	  <?php include 'admin-sidebar.php'; ?>
	  <?php include 'dbconnect.php'; ?>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <style>
table, th, td {
     border: 1px solid black;
}
</style>
	<title>ADMIN INFO</title>
</head>
<body>
  <div class="col-sm-12">
<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
   <!--SHOW CUSTOMERS REGISTERED TO THE BANK ................................................................................................-->



<!--SHOW ACCOUNTS LINKED TO WHICH CUSTOMER REGISTERED TO THE BANK ................................................................................................-->
<h1>Accounts in bank Linked with which Customer</h1>
<?php

$acc = "SELECT c.Firstname,c.Lastname,c.CustomerID,a.Accountnumber,a.Branchcode,a.Accountbalance,a.AccountInitializeDate,a.Accounttype FROM accounts a,customers c WHERE c.CustomerID = a.CustomerID ORDER BY c.CustomerID";
$acc1 = mysql_query( $acc, $conn );

if ($acc1) {
     echo "<table class='table'><tr><th>Customer Name</th><th>Customer ID</th><th>Account Number</th><th>Account Balance</th><th>Account Initialize Date</th><th>Accounttype</th><th>Branchcode</th></tr>";
    while($acc2 = mysql_fetch_array($acc1, MYSQL_ASSOC)) {
         echo "<tr><td>".$acc2["Firstname"]." ".$acc2["Lastname"]."</td><td>".$acc2["CustomerID"]."</td><td>".$acc2["Accountnumber"]."</td><td>".$acc2["Accountbalance"]."</td><td>".$acc2["AccountInitializeDate"]."</td><td>".$acc2["Accounttype"]."</td><td>".$acc2["Branchcode"]."</td></tr>";
     }
     echo "</table>";
}
else {
    echo "No data. You are mysterious.";
}
?>
</div>
  <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>
</html>