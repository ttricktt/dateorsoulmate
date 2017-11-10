<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="includes/css2.css">
</head>
<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
//require_once("includes/form_functions.php");
//Connect to database
db_connect();
?>
<body>
<?php //Display log in form
if (!isset($_SESSION['valid_id'])) { ?>
	<!--div id=""-->
    <h2>Log In</h2>
	<form action="index.php" method="post" class="member" >
	<fieldset>
	<legend>Log In</legend>
	<label for="password"><span>Username:</span><input name=username type=text size="25" maxlength="25"></label>
	<label for="password"><span>Password:</span><input type=password name=passwd size="25" maxlength="25"></label>
	<?php
	if (isset($message)) {
		echo $message;
	}
	?>
</body>
</html>
