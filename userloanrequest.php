<?php
include 'dbconnect.php';
session_start();
$customerid=$_SESSION['customerid'];
?>

<label><b>All Information about loan:</b></label>
<table border="2" >
 <thead>
 	<tr>
 		<th>Loantype</th>
 		<th>Interest</th>
        <th>Maximum Amount</th>
        <th>Minimum Amount</th>
 	</tr>
 </thead>
 <tbody>

<?php
mysql_select_db('evil');
$sql = "SELECT * FROM loantype ";
$retvalue = mysql_query( $sql, $conn );
if(! $retvalue ) 
      {
      die('Could not get data: ' . mysql_error());
      }
 echo "<br>";
while($info = mysql_fetch_array($retvalue, MYSQL_ASSOC)) 
   {
   echo "<tr>
			<td>{$info['Loantype']}</td>
            <td>{$info['Interest1']}</td>
            <td>{$info['MaximumAmount']}</td>
            <td>{$info['MinimumAmount']}</td><br>
         </tr>\n";
   }
?>
</table>
<form action="userloanrequest.php" method="post">
<br>
<label><H1><b>Loan request form:</H1></b></label>
<?php
$options = '';
mysql_select_db('evil');
$type=mysql_query("SELECT Loantype FROM loantype") or die(mysql_error());

while($row = mysql_fetch_array($type)) 
    {
    $options .="<option>" . $row['Loantype'] . "</option>";
    }

$menu="<p><label>Select loan type</label></p>
       <select name='types' id='types'>
       " . $options . "
       </select>";

echo $menu;

?>
<br><br>
<label><b>Loan Amount:</b></label><br>
<input name="amt" class="form-control" placeholder="Example 10000" type="number" required>
<br><br>


<input name="submit" value="Submit" type="submit">
</form>

<?php
         if (isset($_POST['submit'])) 
            {
            $errorcheck = 0;
            $getamt=$_POST['amt'];
            $gettype=$_POST['types'];
            $find=mysql_query("SELECT MaximumAmount,MinimumAmount FROM loantype WHERE Loantype = '$gettype'") or die(mysql_error());
            while($getfind = mysql_fetch_array($find)) 
                {
                $check=$getfind['MaximumAmount'];
                $check1=$getfind['MinimumAmount'];
                if($getamt > $check)
                    {
                    $errorcheck = 1;
                    echo "<script>alert('Cannot put amount more than maximum amount loan can provide');document.location='userpage.php'</script>";
                    }
                if($getamt < $check1)
                    {
                    $errorcheck = 1;
                    echo "<script>alert('Cannot put amount less than minimum amount loan can provide');document.location='userpage.php'</script>";                  
                    }
                }
           if($errorcheck==0)
                {
                $getinterest=mysql_query("SELECT Interest1 FROM loantype WHERE Loantype = '$gettype'") or die(mysql_error());
                while($getInterest = mysql_fetch_array($getinterest)) 
                    {
                    $interest=$getInterest['Interest1'];
                    }
                $insertss="INSERT INTO preloan (Loantype,Interest,Loanamount,CustomerID) VALUES ('$gettype','$interest','$getamt','$customerid')" or die(mysql_error());
                $retvalss = mysql_query( $insertss, $conn );
                if(! $retvalss ) 
                    {
                    die('Could not get data: ' . mysql_error());
                    }
                else
                    {
                    echo "<script>alert('Sucessfully sended the requesr');document.location='userpage.php'</script>";
                    } 
                
                
                } 
           }
?>
