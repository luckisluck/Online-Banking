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
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
<h1>Loan Ongoing</h1>
</div>
  <?php


  $loandetail = "SELECT * FROM loan l,customers c WHERE c.CustomerID = l.CustomerID ORDER BY l.CustomerID";
  $loantable = mysql_query( $loandetail, $conn );

  if ($loantable) {
       echo "<table class='table' border='2' style= 'background-color: #84ed86; color: #761a9b; margin: 0 auto;''>
  <tr><th>Customer Name</th><th>Customer ID</th><th>Loan ID</th><th>Loantype</th><th>Loan Amount</th><th>Intereset</th><th>Loan Start date</th><th>Last Payment Date</th><th>Current Amount</th><th>Total Interest</th></tr>";
      while($loan3 = mysql_fetch_array($loantable, MYSQL_ASSOC)) { 
           echo "<tr><td>".$loan3["Firstname"]." ".$loan3["Lastname"]."</td><td>".$loan3["CustomerID"]."</td><td>".$loan3["LoanID"]."</td><td>".$loan3["Loantype"]."</td><td>".$loan3["Loanamount"]."</td><td>".$loan3["Interest"]."</td><td>".$loan3["StartDate"]."</td><td>".$loan3["LastDate"]."</td><td>".$loan3["CurrentAmount"]."</td><td>".$loan3["TotalInterest"]."</td></tr>";
       }
       echo "</table>";
  }
  else {
      echo "No data. You are mysterious.";
  }
  ?>
   <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


  </body>
  </html>