<?php require_once("includes/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dateorsoulmate.com message page</title>
<link href="includes/css2.css"  media="all" rel="stylesheet" type="text/css" />
</head>
<?php
confirm_logged_in();
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
//Connect to database
db_connect();
?>


<?php 
// This test is used to check if user has a zipcode in the userinfo table. 
// So after the user registers they still don't see the options below in the main menu.
// The purpose of this test is to reduce SPAM until
// the user puts in their zipcode.
 
$row = get_member_info($_SESSION['valid_id']); 
		if (($row[zip]) <= 0) {
		header("location: index.php");
			exit;
	} else {
		

//this test is used to catch message that is clicked.
	if (isset($_GET['messageid'])) {
		$sel_messageid = $_GET['messageid'];
			
		// The AND `to` = {$_SESSION['userid']} statement is used as a security to test if a user 
		// types a message id in the url. If the message is not owned by the user tested by session
		// then the query never succedes. 
		$query = "select * 
			from messages
 			where id = {$sel_messageid}
			AND `to` = {$_SESSION['valid_id']}";
			
		$sel_messageid=mysql_query($query);
		$sel_message=mysql_fetch_array($sel_messageid);
		
		$row = ($sel_message);
		$sel_message = $row[message];
		$sel_message_to = $row[to];
		$sel_message_from = $row[from];	
		$sel_subject = $row[subject];
		$display_message = $sel_message;
		
		
				} else {
		$sel_message_to = "";
	}
	// Reply to message	
	if(isset($_POST['reply'])) {
	$message_from = (mysql_prep($_POST['message_to']));
	$message = (mysql_prep($_POST['message']));
	$subject = (mysql_prep($_POST['subject']));
			$query2 = ("INSERT INTO messages (
			`to`, `from`, `message`, `subject`, `date_submitted`
			) VALUES (
			$message_from,{$_SESSION['valid_id']},'$message','$subject', now() )");
			confirm_query($query2);
			$result = mysql_query($query2);
			}
	if($result) {
		//$query = "SELECT email
			//	FROM register
				//WHERE id = $message_from";
				//$email_result = mysql_query($query);
				//confirm_query($email_result);
				//echo $query; exit;
				//$email = mysql_fetch_array($email_result);
		$to = "rick@dateorsoulmate.com";
		//$subject = "Test email"; 
		$message_from = "Hello, you have a message waiting for you at dateorsoulmate.com \r\nPlease don't reply to this message, go to http://dateorsoulmate.com to read your message.";
		$headers = "From: dateorsoulmate@dateorsoulmate.com\r\nReply-To: noreply@dateorsoulmate.com";
		mail( $to, $subject, $message_from, $headers);
		
	}

?>
<?php
	if (isset($_GET['delete_message'])) 
	{
		$query = "select *
		from messages
		where `to` = {$_SESSION['valid_id']}";
		$message_result = mysql_query($query);
		confirm_query($message_result);
		$count=mysql_num_rows($message_result);
	
	for ($i=0; $i < $count; $i++) 
	{
		$del_id = $checkbox[$i];
		$query = "DELETE FROM messages WHERE id = '$del_id'";
		$result = mysql_query($query);
	}
	if($result)
	{
		echo "<meta http-equiv=\"refresh\"content=\"0;URL=inbox.php\">";
	}
	}
	}
?>
<body>
<div id="bg_wrap">

<?php
display_header();
?>
<div id="message_page">
<h2>Your E-Mail</h2>
<p><span class="message_from_width">From</span>Subject<span class="delete_checbox">Delete</span></p>
<form id="delete_message" method="post" action="?delete_message">
<ul>
<?php // Display all messages
if (logged_in()) {
	$query = "select *
		from messages
		where `to` = {$_SESSION['valid_id']}
		ORDER BY date_submitted DESC
		";
		$message_result = mysql_query($query);
		confirm_query($message_result);
			
	while($row = mysql_fetch_array($message_result)) {
			
				$query = "select username
				from userinfo
				where `valid_id` = $row[from]";
				$from_result = mysql_query($query);
			confirm_query($from_result);
			$from = mysql_fetch_array($from_result);


?>

<li>
<span class="message_from_width"><?php echo $from[username]; ?></span>
<a href=inbox.php?messageid=<?php echo $row[id]; ?>> <?php echo $row[subject]; ?></a>
<span><?php echo $row[date_submitted]; ?></span>
<input class="delete_checbox" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row[id]; ?>" />
</li>
<?php } ?>
	<div>
      <input class="delete_checbox" name="send" id="send" type="submit" value="Delete" />
    </div>
</form>
<?php 
	} //if (logged_in()) 
?>
</ul>
</div>
<?php if (isset($_GET['messageid'])) { // Get message if clicked, display on right side. 

?>
<div id="read_my_message">
<form id="message" method="post" action="?reply">
<ul>
<li><?php echo $display_message; ?></li>

<?php echo $message_to; ?>
</ul>
<p>Reply</p>
<textarea id="message" name="message" cols="40" rows="10"></textarea>
<input type="hidden" name="message_to" id="message_to" value="<?php echo $sel_message_from; ?>" />
<input type="hidden" name="subject" id="subject" value="<?php echo $sel_subject; ?>" />

<div>
     <input class="delete_checbox" name="reply" id="reply" type="submit" value="Send2" />
</div>
</div>
    </form>
<?php } ?>


</div>
</body>
</html>