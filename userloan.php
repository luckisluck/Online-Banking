 <?php

  session_start();
  $customerid=$_SESSION['customerid'];
  $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
 
?>

<!DOCTYPE html>
<html>
<title>Loan</title>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
br {
   display: block;
   margin: 17px 0;
}
</style>
<body>
<div class="container">

<?php 
echo "Loan <br>";
 ?>

 <?php 
  $id = $_SESSION['customerid'];
  echo "Customer :";
  echo $id;
  
 $sql = "SELECT * FROM loan WHERE CustomerID = '$id'";
   mysql_select_db('evil');
  
   $retval = mysql_query( $sql, $conn );
    if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
 ?>
 <table border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;">
 <thead>
 	<tr>
 		<th>Loan ID</th>
 		<th>Loan Type</th>
 		<th>Loan Amount</th>
 		<th>Interest</th>
 		<th>Start Date</th>
    <th>Last Payment Date</th>
    <th>Current Amount</th>
    <th>Total Interest</th>
 		<th></th>
 	</tr>
 </thead>
 <tbody>
 <?php 
$row = mysql_fetch_assoc($retval);
	
	echo "<tr>
			<td>{$row['LoanID']}</td>
			<td>{$row['Loantype']}</td>
			<td>{$row['Loanamount']}</td>
			<td>{$row['Interest']}</td>
			<td>{$row['StartDate']}</td>
      <td>{$row['LastDate']}</td>
      <td>{$row['CurrentAmount']}</td>
      <td>{$row['TotalInterest']}</td>
		  </tr>\n";

  ?>
  </tbody>
 </table>
    <!--<a href="userpage.php">To userpage</a>-->

  <!-- Trigger the modal with a button -->
  <br><br><br>
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Pay Loan</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Loan Payment</h4>
        </div>
        <div class="modal-body">
        <form action="" method="post">
        <?php
        $options = '';
        mysql_select_db('evil');
        $filter=mysql_query("SELECT Accountnumber FROM accounts WHERE CustomerID='$customerid'") or die(mysql_error());
        while($row = mysql_fetch_array($filter)) 
          {
          $options .="<option>" . $row['Accountnumber'] . "</option>";
          $hello=$row['Accountnumber'];
          }

        $menu="<p><label>Select your account</label></p>
        <select name='filter' id='filter'>
        " . $options . "
        </select>";

        echo $menu;
        ?>
        </div>
        <div class="modal-footer">
          <input name="submit" class="btn btn-default" value="Submit" type="submit">
        </div>
       
      </div>
      
    </div>
  </div>
  
</div>
 </form>

<!--SUBMIT AND CALCULATE THE LOAN AND UPDATE BOTH TABLES FOR LOAN PROCESS-->
<?php
if(isset($_POST['submit']))
{
  $error = 0;
  $sql = "SELECT * FROM loan WHERE CustomerID = '$id'";
  $retval = mysql_query( $sql, $conn );
  $row = mysql_fetch_assoc($retval);
  $loanid = $row['LoanID'];
  if($row['CurrentAmount'] == 0)
  {
    $delete = "DELETE FROM loan WHERE LoanID ='$loanid'";
    $delete1 = mysql_query($delete,$conn) or die(mysql_error());
  }
  $accountnumber = $_POST['filter'];
  $loanamount = $row['Loanamount'];
  $startDate = $row['StartDate'];
  $interest = $row['Interest'];
  $lastDate = $row['LastDate'];
  $loantopay = $row['CurrentAmount'];
  $totalinterest = $row['TotalInterest'];
  $today = date("Y-m-d");
  $monthdiff = (int)abs((strtotime($today) - strtotime($lastDate))/(60*60*24*30));
  if($monthdiff == 0)
  {
  $error = 1;
  echo "<script>alert('You are too early Hermano! Payment due in a month');document.location='userpage.php'</script>";
  }
  if($error == 0)
  {
    if($monthdiff == 1)
    {
      $error1 = 0;
      $interestcalc = ($interest/100) * $loantopay;
      $totalinterest = $totalinterest + $interestcalc;
      $topay = round($interestcalc + ($loanamount/12));
      $loantopay = round($loanamount/12);
      echo $topay;
      $acc = "SELECT Accountbalance FROM accounts WHERE Accountnumber = '$accountnumber'";
      $acc1 = mysql_query($acc,$conn) or die(mysql_error());
      $acc2 = mysql_fetch_array($acc1,MYSQL_ASSOC);
      if($topay > $acc2['Accountbalance'])
      {
        $error1 = 1;
        echo "<script>alert('Your Balance is too low, Please deposit or choose another account.');document.location='userpage.php'</script>";
      }
      if($error1 == 0)
      {
        $uppay = "INSERT INTO loanpayment (Datepay,Amount,LoanID) VALUES ('$today','$topay','$loanid')";
        $uppay1 = mysql_query($uppay,$conn) or die(mysql_error());
        $upacc = "UPDATE accounts SET Accountbalance = Accountbalance - '$topay' WHERE Accountnumber = '$accountnumber'";
        $upacc1 = mysql_query($upacc,$conn) or die(mysql_error());
        $uploan = "UPDATE loan SET LastDate = '$today',CurrentAmount = CurrentAmount - '$loantopay',TotalInterest = '$totalinterest' WHERE LoanID = '$loanid'";
        $uploan1 = mysql_query($uploan,$conn) or die(mysql_error());
        echo "<script>alert('Thank you Hermano for the payment, you will be remembered.');document.location='userpage.php'</script>";
      }
    }
  }
  

}
?>


</body>
</html>