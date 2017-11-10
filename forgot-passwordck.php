<?
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using this script.//
/// You can use it at your own risk. /////
//*****************************************

require_once("upyoursbaby/db_fns.php"); // database connection details stored here
require_once("includes/functions.php");
require_once("includes/header.php");
db_connect();
?>
<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Free dating website</title>

<link rel="stylesheet" type="text/css" href="includes/css2.css">

</head>

<body bgcolor="#ffffff" text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000">
<div id="bg_wrap">
<div id="header">
<?php display_header(); ?>
<div id="content">
<?
$email=mysql_real_escape_string($email);
$status = "OK";
$msg="";
//error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
if (!stristr($email,"@") OR !stristr($email,".")) {
$msg="Your email address is not correct<BR>"; 
$status= "NOTOK";}

echo "<br><br>";
if($status=="OK"){  $query="SELECT email,username,passwd FROM register WHERE register.email = '$email'";
$st=mysql_query($query);
 $recs=mysql_num_rows($st);
$row=mysql_fetch_object($st);
$em=$row->email;// email is stored to a variable
 if ($recs == 0) {  echo "<center><font face='Verdana' size='2' color=red><b>No Password</b><br> Sorry Your address is not in our database . You can signup and login to use our site. <BR><BR><a href='register.php'> Sign UP </a> </center>"; exit;}

        $headers4="customercare@dateorsoulmate.com";         ///// Change this address within quotes to your address ///
$headers.="Reply-to: $headers4\n";
$headers .= "From: $headers4\n"; 
$headers .= "Errors-to: $headers4\n"; 
//$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;// for html mail un-comment this line

 if(mail("$em","Your Request for login details","This is in response to your request for login details at site_name \n \nLogin ID: $row->username \n Password: $row->passwd \n\n Thank You \n \n Rick","$headers")){echo "<center><font face='Verdana' size='2' ><b>THANK YOU</b> <br>Your password is posted to your emil address . Please check your mail after some time. After some time if you don’t see an email check your spam folder.</center>";}
else{ echo " <center><font face='Verdana' size='2' color=red >There is some system problem in sending login details to your address. Please contact site-admin. <br><br><input type='button' value='Retry' onClick='history.go(-1)'></center></font>";}


	} 

	else {echo "<center><font face='Verdana' size='2' color=red >$msg <br><br><input type='button' value='Retry' onClick='history.go(-1)'></center></font>";}
?>
</div>
<center>
<br><br><a href='http://www.plus2net.com'>PHP SQL HTML free tutorials and scripts</a></center> 
</div></div>
</body>

</html>
