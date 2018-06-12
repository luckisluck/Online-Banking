<?php
include("dbconnect.php");
?>



<?php

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
    	header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}


$f_name = $_POST["firstname"];
$l_name = $_POST["lastname"];
$d_date = $_POST["bday"];
// $addr = $_POST["Address"];
$gen = $_POST["gender"];
$phone = $_POST["phoneno"];
$u_name = $_POST["username"];
$u_password = $_POST["psw"];
$acc_no = $_POST["Accountno"];
$acc_type = $_POST["at"];
$t_pass = $_POST["tp"];
$branchcode = $_POST["bc"];
$city = $_POST["city"];
$state = $_POST["state"];
$country = $_POST["country"];
$AccountinitializeDate = date("Y-m-d");


$sql = "INSERT INTO customers (Firstname, Lastname, BirthDate, Phonenumber, LoginID, Password, Transactionpassword, City, State, Country,AccountinitializeDate,Branchcode) VALUES ('$f_name', '$l_name','$d_date','$phone','$u_name','$u_password','$t_pass','$city','$state','$country','$AccountinitializeDate','$branchcode')";

if (mysql_query( $sql, $conn ) === TRUE) 
    {
    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
    header( "refresh:1; index.php" ); //wait for 5 seconds before redirecting

    
    }
else 
    {
    echo "<script type='text/javascript'>alert('submission failed! Please try again or Contact the Bank.')</script>";
    header( "refresh:1; index.php" ); //wait for 5 seconds before redirecting
    }
    
    



?>

