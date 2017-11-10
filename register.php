<?php
require_once("includes/session.php");
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");

?>
<?php
$from = ""; // Initialize the email from variable
//Set up regular expression strings to evaluate the value of email variable against 
//$regex1 = '/^[_a-z0-9-][^()<>@,;:\\"[] ]*@([a-z0-9-]+.)+[a-z]{2,4}$/i'; 

	// This code runs only if the username is posted
	if (isset ($_POST['username'])){

	$username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['username']); // filter everything but letters and numbers
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$email1 = $_POST['email1'];
	$email2 = $_POST['email2'];
	$age = preg_replace('#[^0-9]#i', '', $_POST['age']); //just numbers
	$gender = $_POST['gender'];
	$password1 = stripslashes($password1);
	$password2 = stripslashes($password2);
	$email1 = stripslashes($email1);
	$email2 = stripslashes($email2);
	
db_connect();
	 $emailCHecker = mysql_real_escape_string($email1);
	 $emailCHecker = str_replace("`", "", $emailCHecker);
	 // Database duplicate username check setup for use below in the error handling if else conditionals
	 $sql_uname_check = mysql_query("SELECT username FROM register WHERE username='$username'"); 
     $uname_check = mysql_num_rows($sql_uname_check);
     // Database duplicate e-mail check setup for use below in the error handling if else conditionals
     $sql_email_check = mysql_query("SELECT email FROM register WHERE email='$emailCHecker'");
     $email_check = mysql_num_rows($sql_email_check);

	// Error handling for missing data
	if ((!$username) || (!$password1) || (!$password2) || (!$age) || (!$email1) || (!$email2) || (!$gender)) {

	$errorMsg = 'Oops, you did not submit the following required information:<br /><br />';

	if(!$username){
   $errorMsg .= ' * User Name<br />';
	}
	if(!$password1){
	$errorMsg .= ' * Login Password<br />';
	}
	if(!$password2){
	$errorMsg .= ' * Confirm Login Password<br />';
	}
	if(!$age){
	$errorMsg .= ' * Your age<br />';
	}
	if(!$email1){
	$errorMsg .= ' * Choose email<br />';
	}
	if(!$email2){
	$errorMsg .= ' * Renter email<br />';
	}
		if(!$gender){
	$errorMsg .= ' * Choose gender<br />';
	}

	// Run the preg_match function on regex 1 
	} else if (!preg_match('/^[a-z0-9]+@[a-z\.]+$/i', $email1)) { 
			$errorMsg = $email1 . " is an invalid email. Please try again.";
	
	} else if ($email1 != $email2) {
              $errorMsg = 'ERROR: Your Email fields below do not match<br />';
     } else if ($password1 != $password2) {
              $errorMsg = 'ERROR: Your Password fields below do not match<br />';
     } else if ($humancheck != "") {
              $errorMsg = 'ERROR: The Human Check field must be cleared to be sure you are human<br />';		 
     } else if (strlen($username) < 4) {
	           $errorMsg = "<u>ERROR:</u><br />Your User Name is too short. 4 - 20 characters please.<br />"; 
     } else if (strlen($username) > 20) {
	           $errorMsg = "<u>ERROR:</u><br />Your User Name is too long. 4 - 20 characters please.<br />"; 
     } else if ($uname_check > 0){ 
              $errorMsg = "<u>ERROR:</u><br />User Name is already in use. Please try another.<br />"; 
     } else if ($email_check > 0){ 
              $errorMsg = "<u>ERROR:</u><br />Your Email address is already in use inside of our system. Please use another.<br />"; 
     } else { // Error handling is ended, process the data and add member to database

	// END Error handling for missing data
	///////////////////////////////////////////////////////////////////////////////////////////
		$email1 = mysql_real_escape_string($email1);
		$password1 = mysql_real_escape_string($password1);
		
		$db_password = sha1($password1);
		
		 // GET USER IP ADDRESS
		$ipaddress = getenv('REMOTE_ADDR');
		
		$query = ("INSERT INTO register (username, passwd, email, ipaddress, date) VALUES ('{$username}', '{$db_password}', '{$email1}', '{$ipaddress}', now())");
			
			mysql_query($query);
				
 
		$id = mysql_insert_id(); //get new user id
			 
		//The id is used to insert a new row into userinfo. This gets the new user
		//inserted into userinfo and allows the new user to come back to their profile
		//at another time. It inserts the users age, valid_id, gender and date signed up.
					
		// Insert age and gender need to be added to userinfo
		$query = ("INSERT INTO userinfo set
					valid_id='$id', username='$username', age='$age', gender='$gender', date_joined=now()");
		$result = mysql_query($query);
		
		$_SESSION['valid_id'] = $id;
			// Continue to member information from
			header("location: member_profile_form.php");
			exit;
	}
	
	// END if (isset ($_POST['username']
	} else {
		$errorMsg = "";
		$username = "";
		$gender = "";
		$password1 = "";
		$password2 = "";
		$email1 = "";
		$email2 = "";
		$age = "";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="includes/css5.css" rel="stylesheet" type="text/css"/>

<title>Date Or Soulmate</title>
</head>
<body>
<div id="bg_wrap">
<div id="header">
<?php display_header(); ?>
	<div id="wrapper">
	<div id="inner-wrapper">
		<form id="feedback" action="register.php" enctype="multipart/form-data" method="post">
		<table>
          	 <tr>
            <td colspan="2"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
          </tr>

				<tr>
				<td>User Name<span class="red"> *</span></td>
				<td><input name="username" type="text" class="required" id="username" value="<?php print "$username"; ?>" size="32"/></td>
                </tr>

				<tr>
				<td>Password<span class="red"> *</span></td>
				<td><input name="password1" type="text" class="required" id="password1" value="<?php print "$password1" ?>" size="32"/></td>
                </tr>

				<tr>
				<td>Renter password.<span class="red"> *</span></td>
				<td><input name="password2" type="text" class="required" id="password2" value="<?php print "$password2" ?>" size="32"/></td>
                </tr>
				
				<tr>
				<td>Email address.<span class="red"> *</span></td>
				<td><input name="email1" type="text" class="required" id="email1" value="<?php print "$email1" ?>" size="32"/></td>
                </tr>

				<tr>
				<td>Renter email<span class="red"> *</span></td>
				<td><input name="email2" type="text" class="required" id="email2" value="<?php print "$email2" ?>" size="32"/></td>
                </tr>

				<tr>
					<td>Your age.<span class="red"> *</span></td>
					<td><input type="text" name="age" id="age" value="<?php print "$age" ?>" maxlength="5"/></td>
				</tr>
				
				
	
	<tr>
	<td>My Gender<span class="red"> *</span></td>
	<td>
	<select name="gender" id="gender">
	<option value="<?php print "$gender"; ?>"><?php print "$gender"; ?></option>
	<option value="01">Man</option>
	<option value="02">Woman</option>	
	</select>
	</td>
	</tr>

                <tr>
				<td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="honeypot" id="honeypot" value="http://" /></td>
                    <td><input type="hidden" name="humancheck" id="humancheck" class="clear" value="" /></td>
                </tr>
			</table>
        </form>
	</div>
	</div>
	</div>
	</div>
</body>
</html>