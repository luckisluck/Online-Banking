<!DOCTYPE html>
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
$customerid=$_SESSION['customerid'];

mysql_select_db('evil');
$email="SELECT Subject,Message,m.CustomerID,m.EmployeeID,c.Firstname, c.Lastname, e.Employeename FROM mail m,customers c,employees e  WHERE m.CustomerID='$customerid'AND c.CustomerID = m.CustomerID AND e.EmployeeID = m.EmployeeID AND sendtype =1 " ;
$retval = mysql_query( $email, $conn );
    if(! $retval ) 
        {
        die('Could not get data: ' . mysql_error());
        }
  ?>
    <table border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;">
 <thead>
 	<tr>
 		<th>Employeename</th>
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
			<td>from :{$row['Employeename']}</td>
			<td>To :{$row['Firstname']}".$row["Lastname"]."</td>
			<td>{$row['Subject']}</td>
            <td><pre>{$row['Message']}</pre></td>
		  </tr>\n";
        }



?>


</body>
</html>