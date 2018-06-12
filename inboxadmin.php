<!DOCTYPE html>
<?php include 'admin-sidebar.php'; ?>
<html>
<title>Mail</title>
<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn ) 
    {
    die('Could not connect: ' . mysql_error());
    }
session_start();
$adminid=$_SESSION['adminid'];

mysql_select_db('evil');
$email="SELECT Subject,Message,m.CustomerID,m.EmployeeID,c.Firstname, c.Lastname, e.Employeename FROM mail m,customers c,employees e  WHERE m.EmployeeID='$adminid'AND c.CustomerID = m.CustomerID AND e.EmployeeID = m.EmployeeID AND m.sendtype=0  " ;
$retval = mysql_query( $email, $conn );
    if(! $retval ) 
        {
        die('Could not get data: ' . mysql_error());
        }
  ?>
  <div class="col-sm-12">
  <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
    <table class='table' border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;">
 <thead>
 	<tr>
 		<th>Customername</th>
 		<th>Name</th>
        <th>Subject</th>
 		
 		<th>Message</th>
 	</tr>
 </thead>
 <tbody>
    <?php 
    while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) 
        {
       echo "<tr>
			<td>From :{$row['Firstname']}".$row["Lastname"]."</td>
            <td>To :{$row['Employeename']}</td>
			<td>{$row['Subject']}</td>
            <td><pre>{$row['Message']}</pre></td>
		  </tr>\n";
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