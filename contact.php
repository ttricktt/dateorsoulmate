<?php
require_once("includes/session.php");
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
$_SESSION['sel_userid'] = 38;
////////////////////////////////////////////////////////////////////////
//                         Connect to database                        //
////////////////////////////////////////////////////////////////////////
db_connect();
////////////////////////////////////////////////////////////////////////
//                         END Connect to database                        //
////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
//             Someone is tring to log in. Test if user is logged in or not     ///
//////////////////////////////////////////////////////////////////////////////////
	if (isset($_POST['submit2'])) {
	$username = (mysql_prep($_POST[username]));
	$passwd = (mysql_prep($_POST[passwd]));
	// Check database to see if username and password exist
	$query = "SELECT username, passwd, Blocked ";
	$query .= "FROM register ";
	$query .= "WHERE username = '{$username}' ";
	$query .= "AND passwd = '{$passwd}' ";
	$query .= "LIMIT 1";
	$result_set = mysql_query($query);
	confirm_query($result_set);
	if (mysql_num_rows($result_set) == 1) {
	
	$found_user=mysql_fetch_array($result_set);
		if ($found_user[Blocked] == 1) { // ckecked blocked list
			header("location: index.php");
				exit; }
	
	$_SESSION['logged_in_user'] = $found_user['username'];
	$query = "SELECT valid_id, no_display 
				FROM userinfo
				WHERE username = '{$found_user['username']}'";
				
			$user_id = mysql_query($query);
			
			$sel_user_id = mysql_fetch_array($user_id);
			// Set user id
			$_SESSION['valid_id'] = $sel_user_id['valid_id'];
			$_SESSION['no_display'] = $sel_user_id['no_display'];
			// Continue 
			$message = "";
			header("location: contact.php");
				exit;
			} else {
				$message = "Username and password are incorrect.";
	}	
} //if (isset($_POST['submit'])) { 
///////////////////////////////////////////////////////////////////////////////////
//             END Someone is tring to log in.                                 ///
//////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="includes/css5.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="ajax_submit.js"></script>
<title>Date or Soulmate Contact</title>
</head>

<body>
<div id="bg_wrap">
<?php
//////////////////////////////////////////////////////////////////////////////////
//                         Display Header                                      ///
/////////////////////////////////////////////////////////////////////////////////
display_header(); 
//////////////////////////////////////////////////////////////////////////////////
//                         END Display Header                                  ///
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
//                      Show message form                                      ///
//////////////////////////////////////////////////////////////////////////////////

if((isset($_SESSION['valid_id'])) and ($_SESSION['no_display'] == 1)){ // this will show the send message box if user is logged in
			//echo "no display " . $_SESSION['no_display'];
?>

	<div id="wrapper">
    	
                
      <div id="inner-wrapper">
          
		<form id="feedback" action="feedback.php" enctype="multipart/form-data" method="post">
          
          	<div id="response"><!--This will hold our error messages and the response from the server. --></div>           
            
                <p>Leave a message to dateorsoulmate.com</p>
				<div class="inputs">
                  <label>Subject&nbsp;&nbsp;&nbsp;</label>         
                  <input name="subject" type="text" class="required" id="subject" size="60"/>           
                </div>          
                    
            
                <div class="inputs">
                  <label>Message</label>         
                  <textarea name="message" cols="60" rows="" class="required" id="message"></textarea>          
                </div>                       
         
                <div class="button">
                  <input type="submit" name="send" id="send" value="Submit" />
                </div>
                
                <div class="inputs">
                    <input type="hidden" name="honeypot" id="honeypot" value="http://" />            
                    <input type="hidden" name="humancheck" id="humancheck" class="clear" value="" />
                </div>
        </form>
        
      </div><!-- End inner-wrapper -->
                
	</div><!-- End wrapper -->

			<br />
            
<?php if ($return = true) {
	
}            
			
	}//if(isset($_SESSION['valid_id']))
		else // Show login form if user not logged in.
	{
	echo "<p class=\"red\">You need to be logged in to leave a message.</p>";
	//Display log in form
	if (!isset($_SESSION['valid_id'])) { ?>
	<form action="contact.php" method="post" class="member" >
	<fieldset style="width:258px">
	<legend>Log In</legend>
	<label for="username"><span>Username:</span><input name="username" type="text" id="username" maxlength="25"  /></label>
	<label for="password"><span>Password:</span><input type="password" name="passwd" id="password" maxlength="25" /></label><br />
    <span><a href="forgot-password.php">Forgot Password?</a></span>
<?php if (isset($message)) {echo $message; } ?>
	<input name="submit2" id="submit2" type="submit" value="Ok" />
    </fieldset>
	</form>
	<?php }} ?>

<!-- /////////////////////////////////////////////////////////////////////////////
//                      END Show message form                                  ///
///////////////////////////////////////////////////////////////////////////////-->
</div>
</body>
</html>
