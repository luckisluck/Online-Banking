<!DOCTYPE html>
<html>
<title>Account Statement</title>
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
echo $_SESSION['customerid'];
echo $_SESSION['Userid'];
$customerid=$_SESSION['customerid'];
?>



<form action="accstatement.php" method="post">
<br><br>
<?php
$options = '';
mysql_select_db('evil');
$filter=mysql_query("SELECT Accountnumber FROM accounts WHERE CustomerID='$customerid'") or die(mysql_error());

while($row = mysql_fetch_array($filter)) 
{
    $options .="<option>" . $row['Accountnumber'] . "</option>";
    $hello=$row['Accountnumber'];
}

$menu="<p><label>Filter</label></p>
       <select name='filter' id='filter'>
       " . $options . "
       </select>";

echo $menu;

?>
<input name="submit" value="Submit" type="submit">
</form>

<table border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;">
 <thead>
 	<tr>
 		<th>Transaction Date</th>
 		<th>Payment Date</th>
        <th>Accountnumber</th>
        <th>SendtoAccount</th>
 		<th>Amount</th>
 	</tr>
 </thead>
 <tbody>


<?php 
   if (isset($_POST['submit'])) 
   {
       
   $sql = "SELECT TransactionID,TransactionDate,Paymentdate,Accountnumber,CustomerOtherID,Amount FROM transaction WHERE Accountnumber='$hello'";
   mysql_select_db('evil');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   
   echo "<br>";
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) 
   {
      echo "<tr>
			<td>{$row['TransactionDate']}</td>
            <td>{$row['Paymentdate']}</td>
            <td>{$row['Accountnumber']}</td>";
            $sendto = "SELECT Accountnumber,CustomerOtherID FROM transaction WHERE TransactionID =".$row["TransactionID"]." AND sendtype = 1";
            $sendto1 = mysql_query($sendto,$conn);
            if($sendto1){ 
            $sendto2 = mysql_fetch_array($sendto1,MYSQL_ASSOC);
            $sendtoacc =  $sendto2["CustomerOtherID"].$sendto2["Accountnumber"];
            }
            else{echo "No data. You are mysterious.";}
	 echo	"<td>".$sendtoacc."</td>
            <td>{$row['Amount']}</td>
		    </tr>\n";
   }
   
   echo "Fetched data successfully\n";
   }
   mysql_close($conn);
?>
<br><br>
     




</body>
</html>