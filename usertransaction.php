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

<form action="usertransaction.php" method="post">
<br><br>
<?php
$options = '';
$options1 = '';
mysql_select_db('evil');
$filter=mysql_query("SELECT Accountnumber FROM accounts WHERE CustomerID='$customerid'") or die(mysql_error());

while($row = mysql_fetch_array($filter)) 
{
    $options .="<option>" . $row['Accountnumber'] . "</option>";
    $hello=$row['Accountnumber'];
}

$menu="<p><label>Select you account</label></p>
       <select name='filter' id='filter'>
       " . $options . "
       </select>";

echo $menu;


$bname=mysql_query("SELECT Bankname FROM otherbank ") or die(mysql_error());
while($rowb = mysql_fetch_array($bname)) 
{
    $options1 .="<option>" . $rowb['Bankname'] . "</option>";

}

$menus="<p><label>Select bank you want to transfer to</label></p>
       <select name='bankn' id='bankn'>
       <option value='Evil Bank'>Evil Bank</option>     
       " . $options1 . "
       </select>";

echo $menus;



?>
<br><br>
<label><b>Enter account number you want to transfer:</b></label><br>
<input name="accno" placeholder="Example 123456789" type="text" required>
<br><br>

<br><br>
<label><b>Enter amount you want to transfer:</b></label><br>
<input name="accamt" placeholder="Example 123456789" type="number" required>
<br><br>

<label><b>When to pay:</b></label><br>
<input type="radio" name="pay" value="paynow" required> Paynow
<input type="radio" name="pay" value="paylater" required> Paylater
<br><br>



<br><br>
<label><b>Enter your transaction password:</b></label><br>
<input name="psw" type="password" required>
<br><br>


<input name="submit" value="Submit" type="submit">
</form>

<?php
if (isset($_POST['submit'])) 
   { 
    $bankname=$_POST['bankn'];
    $useracc=$_POST['filter'];
    $getaccno=$_POST['accno'];
    $getaccamt=$_POST['accamt'];
    $psw=$_POST['psw'];
    $gen = $_POST["pay"];
    echo $getaccno;
    echo $getaccamt;
    echo $psw;
    echo $gen;
    
    
    $tranuser=mysql_query("SELECT CustomerID,Accountnumber FROM accounts WHERE Accountnumber = '$getaccno'  ") or die(mysql_error());
    $checkrow=mysql_num_rows($tranuser);
    if($checkrow == 0)
        {
            if( $bankname == "Hitler" || $bankname == "Butter"  )
            {  
            $otheruser=mysql_query("SELECT CustomerOtherID,Accountnumber FROM payee WHERE Accountnumber = '$getaccno'  ") or die(mysql_error());        
            $getthis=mysql_num_rows($otheruser);
                if($getthis == 0)
                {
                echo "<script>alert('Invalid External account number');document.location='userpage.php'</script>"; 
                }          
            }
            else 
            {
              echo "<script>alert('Invalid Internal account number');document.location='userpage.php'</script>"; 
            }
        }
        
     while($transferuser = mysql_fetch_array($tranuser, MYSQL_ASSOC)) 
        {  
        $gettranuser=$transferuser['CustomerID'];                           
        }
    
    $result=mysql_query("SELECT Accountnumber,Accountbalance FROM accounts WHERE  CustomerID = '$customerid'") or die(mysql_error());
    
    while($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
        {
        if($row['Accountnumber'] == $getaccno)
               {
               $error = 1;
               echo "<script>alert('You can not use your own account number to transfe to');document.location='userpage.php'</script>";              
               }
        else if ($row['Accountbalance'] < $getaccamt)
                {
                $error = 1;
                echo "<script>alert('Insufficient Fund');document.location='userpage.php'</script>";
                }
        else if ($getaccamt < 0)
                {
                $error = 1;
                echo "<script>alert('Only positive value');document.location='userpage.php'</script>";
                }
        
        }
    if($error == 0 )
    {
    $result=mysql_query("SELECT Transactionpassword FROM customers WHERE CustomerID='$customerid'  and Transactionpassword='$psw'") or die(mysql_error());
    $CreateDate = date("Y-m-d");
    date_default_timezone_set('Asia/Bangkok');
    $transfertime = date("Y-m-d H:i:s",time());
    $count=mysql_num_rows($result);
        if($count==1)
            {
                if($bankname == "Evil Bank")
                {
                    if($gen == "paylater")
                        {
                        $getprimary=mysql_query("SELECT MAX(PretransactionID) AS maxs FROM pretransaction") or die(mysql_error());
                        while($rows = mysql_fetch_array($getprimary, MYSQL_ASSOC)) 
                            {   
                            $getp=$rows['maxs'];
                            }
                        $getp=$getp+1;
                        echo "this is primary key".$getp;
                        $insert="INSERT INTO pretransaction (PretransactionID,TransactionDate,Accountnumber,Amount,Paymentstatus,sendtype) VALUES ('$getp','$transfertime', '$useracc','$getaccamt','Pending',0)" or die(mysql_error());
                        $retval = mysql_query( $insert, $conn );
                        if(! $retval ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $insertss="INSERT INTO pretransaction (PretransactionID,TransactionDate,Accountnumber,Amount,Paymentstatus,sendtype) VALUES ('$getp','$transfertime', '$getaccno','$getaccamt','Pending',1)" or die(mysql_error());
                        $retvalss = mysql_query( $insertss, $conn );
                        if(! $retvalss ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $update="UPDATE accounts SET Accountbalance = Accountbalance - $getaccamt WHERE CustomerID =$customerid";
                        $updatecheck = mysql_query( $update, $conn );
                        if(! $updatecheck ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                    
                        $updates="UPDATE accounts SET Accountbalance = Accountbalance + $getaccamt WHERE CustomerID =$gettranuser";
                        $updatechecks = mysql_query( $updates, $conn );
                        if(! $updatechecks ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        }   
                    
                    
                    
                else if ($gen == "paynow")
                    {
                        $getprimary=mysql_query("SELECT MAX(TransactionID) AS maxs FROM transaction") or die(mysql_error());
                        while($rows = mysql_fetch_array($getprimary, MYSQL_ASSOC)) 
                            {   
                            $getp=$rows['maxs'];
                            }
                        $getp=$getp+1;
                        echo "this is primary key".$getp;
                        $insert="INSERT INTO transaction (TransactionID,TransactionDate,PaymentDate,Accountnumber,Amount,sendtype) VALUES ('$getp','$transfertime','$transfertime', '$useracc','$getaccamt',0)" or die(mysql_error());
                        $retval = mysql_query( $insert, $conn );
                        if(! $retval ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $insertss="INSERT INTO transaction (TransactionID,TransactionDate,PaymentDate,Accountnumber,Amount,sendtype) VALUES ('$getp','$transfertime','$transfertime', '$getaccno','$getaccamt',1)" or die(mysql_error());
                        $retvalss = mysql_query( $insertss, $conn );
                        if(! $retvalss ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $update="UPDATE accounts SET Accountbalance = Accountbalance - $getaccamt WHERE CustomerID =$customerid";
                        $updatecheck = mysql_query( $update, $conn );
                        if(! $updatecheck ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                    
                        $updates="UPDATE accounts SET Accountbalance = Accountbalance + $getaccamt WHERE CustomerID =$gettranuser";
                        $updatechecks = mysql_query( $updates, $conn );
                        if(! $updatechecks ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        
                    }
                }
                #START OF OTHER BANK
                else if ($bankname == "Butter" || $bankname == "Hitler")
                    {
                     if($gen == "paylater")
                        {
                        $getprimary=mysql_query("SELECT MAX(PretransactionID) AS maxs FROM pretransaction") or die(mysql_error());
                        while($rows = mysql_fetch_array($getprimary, MYSQL_ASSOC)) 
                            {   
                            $getp=$rows['maxs'];
                            }
                        $getp=$getp+1;
                        echo "this is primary key".$getp;
                        $insert="INSERT INTO pretransaction (PretransactionID,TransactionDate,Accountnumber,Amount,Paymentstatus,sendtype) VALUES ('$getp','$transfertime', '$useracc','$getaccamt','Pending',0)" or die(mysql_error());
                        $retval = mysql_query( $insert, $conn );
                        if(! $retval ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $insertss="INSERT INTO pretransaction (PretransactionID,TransactionDate,CustomerOtherID,Amount,Paymentstatus,sendtype) VALUES ('$getp','$transfertime', '$getaccno','$getaccamt','Pending',1)" or die(mysql_error());
                        $retvalss = mysql_query( $insertss, $conn );
                        if(! $retvalss ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $update="UPDATE accounts SET Accountbalance = Accountbalance - $getaccamt WHERE CustomerID =$customerid";
                        $updatecheck = mysql_query( $update, $conn );
                        if(! $updatecheck ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                    
                        }   
                    
                    
                    
                else if ($gen == "paynow")
                    {
                        $getprimary=mysql_query("SELECT MAX(TransactionID) AS maxs FROM transaction") or die(mysql_error());
                        while($rows = mysql_fetch_array($getprimary, MYSQL_ASSOC)) 
                            {   
                            $getp=$rows['maxs'];
                            }
                        $getp=$getp+1;
                        echo "this is primary key".$getp;
                        $insert="INSERT INTO transaction (TransactionID,TransactionDate,PaymentDate,Accountnumber,Amount,sendtype) VALUES ('$getp','$transfertime','$transfertime', '$useracc','$getaccamt',0)" or die(mysql_error());
                        $retval = mysql_query( $insert, $conn );
                        if(! $retval ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $insertss="INSERT INTO transaction (TransactionID,TransactionDate,PaymentDate,CustomerOtherID,Amount,sendtype) VALUES ('$getp','$transfertime','$transfertime', '$getaccno','$getaccamt',1)" or die(mysql_error());
                        $retvalss = mysql_query( $insertss, $conn );
                        if(! $retvalss ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        $update="UPDATE accounts SET Accountbalance = Accountbalance - $getaccamt WHERE CustomerID =$customerid";
                        $updatecheck = mysql_query( $update, $conn );
                        if(! $updatecheck ) 
                            {
                            die('Could not get data: ' . mysql_error());
                            }
                        
                    }   
                      
                        
                    }
                
                
                
                
                
                
                
            echo "Look good brah";
            }
    }
    

   }

?>



