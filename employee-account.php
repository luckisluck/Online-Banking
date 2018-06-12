<?php include 'employee-sidebar.php'; ?>
<?php
  session_start();
  ?>
  <html>
  <head>
  	<title>Info</title>
  </head>
  <body>
  <style>
  table, th, td {
       border: 1px solid black;
  }
  </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <?php include 'dbconnect.php'; ?>
  <br>
  <body>
      <div class="col-sm-12">


<!--SHOW ACCOUNTS LINKED TO WHICH CUSTOMER REGISTERED TO THE BANK ................................................................................................-->
<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
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