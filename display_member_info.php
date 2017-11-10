<?php
session_start();
echo "<title>Free Dating Website Dateorsoulmate.com</title>";
//require_once("user_auth_fns.php");
//require_once("html_header.php");
//require_once("includes/login.php");
//require_once("footer.php");
?>

<?php
//echo ("Welcome $valid_user</font>");
//do_html_header();

// connect to db
  $conn = @mysql_pconnect("p50mysql53.secureserver.net","dateorsoulmate","bi5%2cUx")
  		or die("Could not connect to database");
  mysql_select_db("dateorsoulmate")
		or die("Could not connect");
		
	$result = "select * from userinfo where valid_id = $_GET[userid]";
  	$get_member_res = mysql_query($result) or die (mysql_error());
  		if (mysql_num_rows($get_member_res) < 1){
  			$display_block .= "<p><em>Invalid item selection.</em></p>";
		} else {

	$picture_result = "select * from pictures where user_id = $_GET[userid]";
	$get_picture_res = mysql_query($picture_result) or die (mysql_error());
	

$username = stripslashes(mysql_result($get_member_res,0,'username'));
$interest = stripslashes(mysql_result($get_member_res,0,'interest'));
$aboutme = stripslashes(mysql_result($get_member_res,0,'aboutme'));
$seeking = stripslashes(mysql_result($get_member_res,0,'seeking'));
$gender = stripslashes(mysql_result($get_member_res,0,'gender'));
$height = stripslashes(mysql_result($get_member_res,0,'height'));
$body_type = stripslashes(mysql_result($get_member_res,0,'body_type'));
$hair_color = stripslashes(mysql_result($get_member_res,0,'hair_color'));
$married = stripslashes(mysql_result($get_member_res,0,'marital_status'));
$smoke = stripslashes(mysql_result($get_member_res,0,'smoke'));
if (mysql_num_rows($get_picture_res) > 0) {
$picture = (mysql_result($get_picture_res,0,'file_name')); }
 



// Get height from user profile and reference height table
	
  $result_height = "select height from height where id = $height";
  $get_height_res = mysql_query($result_height) or die (mysql_error());
  if (mysql_num_rows($get_height_res) > 0) {
  $user_height = stripslashes(mysql_result($get_height_res,0,'height')); }
  
	
  $result_body_type = "select body_type from body_type where id = $body_type";
  $get_body_type_res = mysql_query($result_body_type) or die (mysql_error());
  if (mysql_num_rows($get_body_type_res) > 0) {
  $user_body_type = stripslashes(mysql_result($get_body_type_res,0,'body_type')); }
  
  $result_hair_color = "select hair from hair where id = $hair_color";
  $get_hair_color_res = mysql_query($result_hair_color) or die (mysql_error());
  if (mysql_num_rows($get_hair_color_res) > 0) {
  $user_hair_color = stripslashes(mysql_result($get_hair_color_res,0,'hair')); }
  
  $result_married = "select status from married where id = $married";
  $get_married_res = mysql_query($result_married) or die (mysql_error());
  if (mysql_num_rows($get_married_res) > 0) {
  $user_married = stripslashes(mysql_result($get_married_res,0,'status')); }
  
  $result_gender = "select male_female from male_female where id = $gender";
  $get_gender_res = mysql_query($result_gender) or die (mysql_error());
  if (mysql_num_rows($get_gender_res) > 0) {
  $user_gender = stripslashes(mysql_result($get_gender_res,0,'male_female')); }
  
  $result_seeking = "select seeking from seeking where id = $seeking";
  $get_seeking_res = mysql_query($result_seeking) or die (mysql_error());
  if (mysql_num_rows($get_seeking_res) > 0) {
  $user_seeking = stripslashes(mysql_result($get_seeking_res,0,'seeking')); }
  
?>

<?php
	$display_block .= 
	"<table align=center>
	<tr>
	
	<td>Member Name: <td>$username</td>
	</tr>
	<tr>
	<td>I am a: <td>$user_gender</td></td>
	</td>
	
	<tr><td valign=middle width=150>Looking For: <td>$user_seeking</td></td></tr>
	<tr><td valign=middle width=100>Height: <td>$user_height</td></td></tr>
	<tr><td valign=middle width=250>Body Type: <td>$user_body_type</td></td></tr>
	<tr><td valign=middle width=150>Hair Color: <td>$user_hair_color</td></td></tr>
	<tr><td valign=middle width=150>Marital Status: <td>$user_married</td></td></tr>
	<tr><td colspan=2 valign=middle width=400>My Interest: $interest</td></tr>
	<tr>
	<td colspan=2 valign=middle width=400>About Me: $aboutme</td>
	</tr>
	</table>";

?>

<?php
	
}

print $display_block; 

//echo "<img src=$picture>";
//echo "<img src=imageresize.php?image=$picture>";
?>

<? if (session_is_registered(valid_user)) {
// if logged in I need to send the userid to email_form.php
//echo "<table align=center><tr><td align=center><strong>";
?>
<div id="email_member">
<?php
echo "<p><a href=email_form.php?userid=$userid>Send a message to $username.</a></p><br /><br />";
//echo "</strong></td></tr></table>";
?>
</div></div>
<div id="clear"></div>

<?php

// $selected_userid is loaded from the value $userid from the function in list_members.php
$id=$userid;
session_register("id");
//echo "<br>selected user id $id";
}
//do_footer(); 
?>




