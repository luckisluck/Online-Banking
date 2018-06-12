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
  <body><div class="col-sm-12">
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
<h1 >Customers in Bank</h1></div>
  <?php

   if(isset($_POST['delete'])){
         $id = $_POST['delete_rec_id1'];  
         $query = "DELETE FROM customers WHERE CustomerID=$id"; 
         $result = mysql_query( $query, $conn );
      }
  $sql = "SELECT * FROM customers";
  $result = mysql_query( $sql, $conn );

  if ($result) {
       echo "<table class='table' border='2' style= 'background-color: #84ed86; color: #761a9b; margin: 0 auto;''>
  <tr><th>Customer Name</th><th>Customer ID</th><th>Branch Code</th><th>City</th><th>Account Start Date</th><th>Lastlogin</th><th>Delete</th></tr>";
      while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
          $cid = $row["CustomerID"]; 
           echo "<tr><td>".$row["Firstname"]." ".$row["Lastname"]."</td><td>".$row["CustomerID"]."</td><td>".$row["Branchcode"]."</td><td>".$row["City"]."</td><td>".$row["AccountinitializeDate"]."</td><td>".$row["Lastlogin"]."</td><td><form id='delete' method='post' action=''>
          <input type='hidden' name='delete_rec_id1' value='$cid'/> 
          <input type='submit' name='delete' value='Delete!'/></form></td></tr>";
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