<?php require_once("includes/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="includes/css2.css" />
</head>
<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
//Connect to database
db_connect();
$valid_id =  $_SESSION['valid_id'];

if (array_key_exists('submit',$_POST)){
$query = "INSERT INTO announcements (

			user_id, announcement, date

				) VALUES (

					'{$valid_id}', '{$announcement}', now()

				)";
				mysql_query($query);
				
				header("location: index.php");
					exit;
				}
				
				
?>

<body>
<div id="bg_wrap">
<div id="header">
<?php display_header(); ?>
</div><!-- End <div id="header"> -->

<div id="content2">

<?php //Someone is tring to log in. Test if user is logged in or not
	if (isset($_POST['submit'])) {
	$username = (mysql_prep($_POST[username]));
	$passwd = (mysql_prep($_POST[passwd]));
	
	$query = "SELECT username, passwd ";
	$query .= "FROM register ";
	$query .= "WHERE username = '{$username}' ";
	
	$query .= "AND passwd = '{$passwd}' ";
	
	$query .= "LIMIT 1";
	$result_set = mysql_query($query);
	
	confirm_query($result_set);
	if (mysql_num_rows($result_set) == 1) {
	$found_user=mysql_fetch_array($result_set);
	$_SESSION['logged_in_user'] = $found_user['username'];
	$query = "SELECT valid_id 
				FROM userinfo
				WHERE username = '{$found_user['username']}'";
				
			$user_id = mysql_query($query);
			
			$sel_user_id = mysql_fetch_array($user_id);
			// Set user id
			$_SESSION['valid_id'] = $sel_user_id['valid_id'];
			// Continue 
			$message = "";
			header("location: announce.php");
				exit;
			} else {
				$message = "Username or password is incorrect.";
	}	
} //if (isset($_POST['submit'])) { 

if(!isset($_SESSION['valid_id'])) { // If user not logged in show login form

//Display log in form ?>

	<form action="announce.php" method="post" class="member" >
	<fieldset>
	<legend>Log In</legend>
	<label for="password"><span>Username:</span><input name=username type=text size="25" maxlength="25"></label>
	<label for="password"><span>Password:</span><input type=password name=passwd size="25" maxlength="25"></label>
    <span><a href="forgot-password.php">Forgot Password?</a></span>
	<?php
		if (isset($message)) {	echo $message;	}
	?>
	</fieldset>
	 <div>
      <input name="submit" id="submit" type="submit" value="Ok" />
    </div>
	</form>
    
    <?php } else {
	
	// Make an announcement ?>
    <form id="annoucement"  method="post" action="">
     <label for="announcement"><span>Create an annoucement</span>
     <textarea id="announcement" name="announcement" cols="60" rows="3"></textarea>

	</label>
    <input name="submit" id="submit" type="submit" value="Announcement" />
    </form>
    
<?php } ?>
</div><!-- End <div id="content2"> -->
</div><!-- End <div id="bg_wrap"> -->
</body>
</html>
