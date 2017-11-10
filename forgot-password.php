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

<body>

<div id="bg_wrap">
<div id="header">
<?php display_header(); ?>
<form id="reset" class="member" action='forgot-passwordck.php' method=post>
<div id="content">
<fieldset>
<label for="password">Forgot Password ?<br />Enter your email address<br /><br /></label>

<label for="email"><span>Email</span></label>

<input type ='text' class='bginput' name='email' >

<input type='submit' value='Submit'> 
<input type='reset' value='Reset'>

</fieldset>
</div>
</form>
</div></div>
</body>

</html>
