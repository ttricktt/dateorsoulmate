<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php $valid_id =  $_SESSION['valid_id'];
require_once("includes/functions.php");
require_once("upyoursbaby/db_fns.php");
db_connect();
?>
<?php
sleep(2);
//Sanitize incoming data and store in variable
$subject = trim(stripslashes(htmlspecialchars($_POST['subject'])));	  		
$message = trim(stripslashes(htmlspecialchars($_POST['message'])));	    
$humancheck = $_POST['humancheck'];
$honeypot = $_POST['honeypot'];

if ($honeypot == 'http://' && empty($humancheck)) {	
		
		//Validate data and return success or error message
		$error_message = '';	
		
		if (empty($subject)) {
				   
				    $error_message .= "<p>Please provide a subject.</p>";			   
		}			
		if (empty($message)) {
					
					$error_message .= "<p>A message is required.</p>";
		}		
		if (!empty($error_message)) {
					$return['error'] = true;
					$return['msg'] = "<h3>Oops! The request was successful but your form is not filled out correctly.</h3>".$error_message;					
					echo json_encode($return);
					exit();
		} else {
							  
			$return['error'] = false;
			$return['msg'] = "<p>Your message has been sent.</p>"; 
			
			
			$query = ("INSERT INTO messages (
			`to`, `from`, `message`, `subject`, `date_submitted`
			) VALUES (
			{$_SESSION['sel_userid']},{$_SESSION['valid_id']},'$message', '$subject', now() )");
			confirm_query($query);
			mysql_query($query);
			/*$email_sql = "select email from register
							where id = '$row[valid_id]'";
						$email_result = mysql_query($email_sql);
						$email = mysql_fetch_array($email_result);
									
			$to = "$email[email]" ;
			//$subject = "Test email"; 
		$message_from = "Hello, you have a message waiting for you at dateorsoulmate.com \r\nPlease don't reply to this message, go to http://dateorsoulmate.com to read your message.";
		$headers = "From: dateorsoulmate@dateorsoulmate.com\r\nReply-To: noreply@dateorsoulmate.com";
		mail( $to, $subject, $message_from, $headers);*/
		echo json_encode($return);
		  }		
} else {
	
	$return['error'] = true;
	$return['msg'] = "<h3>Oops! There was a problem with your submission. Please try again.</h3>";	
	echo json_encode($return);
}
	
?> 

