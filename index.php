<?php
require_once("includes/session.php");
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
require_once("includes/text.php");
require_once("includes/search_form_fn.php");
require_once('includes/zipcode.class.php');      // zip code class

////////////////////////////////////////////////////////////////////////
//                         Connect to database                        //
////////////////////////////////////////////////////////////////////////
db_connect();
////////////////////////////////////////////////////////////////////////
//                         END Connect to database                        //
////////////////////////////////////////////////////////////////////////

// ------- ESTABLISH THE PROFILE INTERACTION TOKEN ---------
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum); // Will always overwrite itself each time this script runs
// ------- END ESTABLISH THE PROFILE INTERACTION TOKEN ---------
?>
<?php 
////////////////////////////////////////////////////////////////////////////////////////////
/////// This test is used to catch member info after clicked from main content area     ///
///////////////////////////////////////////////////////////////////////////////////////////
		if (isset($_GET['choose_userid'])) {
		
		$sel_userid = $_GET['choose_userid'];
		$_SESSION['sel_userid'] = $sel_userid;
		$row = get_member_info($sel_userid);
		$sel_state = get_state($row[state]);
		$sel_zip = ($row[zip]);
		$sel_seeking = get_seeking($row[seeking]);	
		$sel_username = $row[username];
		$sel_age = $row[age];
		$sel_interest = $row[interest];
		$sel_aboutme = $row[aboutme];
		$sel_First_Date = $row[First_Date];
		$sel_body_type = get_body_type($row[body_type]);
		$sel_gender = get_gender($row[gender]);
		$sel_do_i_drink = get_do_i_drink($row[drink]);
		$sel_ethnicity = get_my_ethnicity($row[ethnicity]);
		$sel_hair = get_my_hair($row[hair_color]);
		$sel_height = get_height($row[height]);
		$sel_relationship_status = get_relationship_status($row[marital_status]);
		$sel_dating = get_dating($row[lookingfor]);
		$sel_smoking = get_smoking($row[smoke]);
		$sel_picture_sql = "select * from pictures
 				where user_id = '$row[valid_id]'";
				//and file_name is not null";
	$sel_picture_result=mysql_query($sel_picture_sql);
		//$sel_picture=mysql_fetch_array($sel_picture_result);
							
		} else {
			$sel_userid = "";
	}
/////////////////////////////////////////////////////////////////////////////////////
// END test used to catch member info after clicked from the leftside of users.///
/////////////////////////////////////////////////////////////////////////////////////
?>
<?php 
///////////////////////////////////////////////////////////////////////////////////
//             Someone is trying to log in. Test if user is logged in or not     ///
//////////////////////////////////////////////////////////////////////////////////
	if (isset($_POST['submit'])) {
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
			header("location: index.php");
				exit;
			} else {
				$message = "Username and password are incorrect.";
	}	
} //if (isset($_POST['submit'])) { 
///////////////////////////////////////////////////////////////////////////////////
//             END Someone is tring to log in.                                 ///
//////////////////////////////////////////////////////////////////////////////////
?>
<?php $result = mysql_query("select * from userinfo where no_display = '1' order by date_joined desc"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="includes/css5.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="ajax_submit.js"></script>
<title>DateOrSoulmate</title>
</head>
<body>
<div id="bg_wrap">
<!-- /////////////////////////////////////////////////////////////////////////////
//                         Display Header                                      ///
///////////////////////////////////////////////////////////////////////////////-->
<?php display_header(); ?>

<!-- /////////////////////////////////////////////////////////////////////////////
//                         END Display Header                                  ///
///////////////////////////////////////////////////////////////////////////////-->

<!-- /////////////////////////////////////////////////////////////////////////////
//     If user is logged in show search form                                   ///
///////////////////////////////////////////////////////////////////////////////-->
<?php if (isset($_SESSION['valid_id'])) { ?>
<table width="800px"><tr><td><?php display_search_form();?></td></tr></table>
<?php } ?>
<!-- /////////////////////////////////////////////////////////////////////////////
//     END If user is logged in show search form                               ///
///////////////////////////////////////////////////////////////////////////////-->


<div id = "content">
<!-- /////////////////////////////////////////////////////////////////////////////
//                      If a user is clicked show results                      ///
///////////////////////////////////////////////////////////////////////////////-->
<?php

	if (isset($_GET['choose_userid'])) { //If user is clicked then show on top of page ?>
		
		<table class="user_description">
			<tr>
				<td class="greenBold">About: <?php echo $sel_username ?></td>
				<td class="greenBold">Age: <span class="about"><?php echo $sel_age ?></span></td>
				<td class="greenBold">State: <span class="about"><?php echo $sel_state[states] ?></span></td>
			</tr>
			<tr>
				<td class="greenBold">I'm a <span class="about"><?php echo $sel_gender[male_female] ?></span></td>
				<td class="greenBold">Relationship status: <span class="about"><?php echo $sel_relationship_status[status] ?></span></td>
				<td class="greenBold">Ethnicity: <span class="about"><?php echo $sel_ethnicity[ethnicity] ?></span></td>
			</tr>
			<tr>
				<td class="greenBold">Looking for <span class="about"><?php echo $sel_seeking[seeking] ?></span></td>
				<td class="greenBold">For: <span class="about"><?php echo $sel_dating[relationship] ?></span></td>
				<td class="greenBold">Height: <span class="about"><?php echo $sel_height[height] ?></span></td>
			</tr>
			<tr>
				<td class="greenBold" colspan="3">About: <span class="about"><?php echo $sel_aboutme ?></span></td>
			</tr>
			<tr>
				<td class="greenBold" colspan="3">First Date: <span class="about"><?php echo $sel_First_Date ?></span></td>
			</tr>
			</table>
<!-- /////////////////////////////////////////////////////////////////////////////
//                      Show images for clicked user                           ///
///////////////////////////////////////////////////////////////////////////////-->			
	<table>
	<tr>
	<td>
<?php	
	while($sel_picture=mysql_fetch_array($sel_picture_result)) { 
	if ($sel_picture[ok_to_show]==1) { 
?>
	<img src="imageresize_large.php?image=pictures/<?php echo $sel_picture[file_name] ?>" alt="dating" />
<?php
	} //if ($sel_picture)
	} //while($sel_picture=mysql_fetch_array($sel_picture_result))
?>
	</td>
	</tr>
	</table>
<!-- /////////////////////////////////////////////////////////////////////////////
//                      END Show images for clicked user                       ///
///////////////////////////////////////////////////////////////////////////////-->

<!-- /////////////////////////////////////////////////////////////////////////////
//                      Show message form for clicked user                     ///
///////////////////////////////////////////////////////////////////////////////-->
<?php
if((isset($_SESSION['valid_id'])) and ($_SESSION['no_display'] == 1)){ // this will show the send message box if user is logged in
			//echo "no display " . $_SESSION['no_display'];
?>

	<div id="wrapper">
    	
                
      <div id="inner-wrapper">
          
		<form id="feedback" action="feedback.php" enctype="multipart/form-data" method="post">
          
          	<div id="response"><!--This will hold our error messages and the response from the server. --></div>           
            
                <p>Send <?php echo $sel_username ?> a message</p>
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
?>
<!-- /////////////////////////////////////////////////////////////////////////////
//                      END Show message form for clicked user                 ///
///////////////////////////////////////////////////////////////////////////////-->
<?php } //END - if (isset($_GET['choose_userid']))?>			
<!-- /////////////////////////////////////////////////////////////////////////////
//                      END If a user is clicked show results                  ///
///////////////////////////////////////////////////////////////////////////////-->

<!-- /////////////////////////////////////////////////////////////////////////////
//                       Display users on main page                            ///
///////////////////////////////////////////////////////////////////////////////-->
<table width="800px" align="center" cellspacing="1">
  <tr>
  	<td  width="527px">
    <ul>
        <?php while($row = mysql_fetch_array($result)) { ?>
		
		
	
	<?php
	$picture_sql = "select * from pictures
 				where user_id = '$row[valid_id]'";
				//and file_name is not null";
				$picture_result=mysql_query($picture_sql);
				$picture=mysql_fetch_array($picture_result); 
		
	$state_sql = "select * from states
 				where id = '$row[state]'";
	$state_result=mysql_query($state_sql);
	$state=mysql_fetch_array($state_result);
	
	$gender_sql = "select * from male_female
 				where id = '$row[gender]'";
	$gender_result=mysql_query($gender_sql);
	$gender=mysql_fetch_array($gender_result);
	
		$username = $row[username];
		$choose_userid = $row[valid_id];
		$aboutme = $row[aboutme];
		$age = $row[age];
		$interest = $row[interest];
	?>	
    	
			

    <?php if($picture) {   ?>
	
	
    <?php if ($picture[ok_to_show]==1) { ?>
	
    <li>
    <a href="index.php?choose_userid=<?php echo $choose_userid; ?>">
    <img height="80px" width="80px" src="imageresize2.php?image=pictures/<?php echo $picture[file_name];?>" alt="dating" /><br />
	<?php echo $username; ?><br />
    <?php echo $gender[male_female] . ", ". $age ; ?></a>
   </li>
	<?php } ?>
	 

     

<?php } //if($picture) ?>

<?php } ?>
</ul>
</td>


    <td valign="top" width="259px">
<?php //Display log in form
	if (!isset($_SESSION['valid_id'])) { ?>
	<form action="index.php" method="post" class="member" >
	<fieldset style="width:258px">
	<legend>Log In</legend>
	<label for="username"><span>Username:</span><input name="username" type="text" id="username" maxlength="25"  /></label>
	<label for="password"><span>Password:</span><input type="password" name="passwd" id="password" maxlength="25" /></label><br />
    <span><a href="forgot-password.php">Forgot Password?</a></span>
<?php if (isset($message)) {echo $message; } ?>
	<input name="submit" id="submit" type="submit" value="Ok" />
    </fieldset>
	</form>
<?php } ?>   
<br />
<p class="font80"><a href="contact.php">Click here if you have questions about this website?</a></p>
<br />

<script type="text/javascript"><!--
google_ad_client = "ca-pub-0217399261566211";
/* skyscraper */
google_ad_slot = "6859227002";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>
 </tr>

</table>
<!-- /////////////////////////////////////////////////////////////////////////////
//                       END Display users on main page                        ///
///////////////////////////////////////////////////////////////////////////////-->
<table>
<tr>
<td>
 <a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-xhtml10"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>

</td>
<td>
<a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="Valid CSS!" />
    </a>

</td>
</tr>
</table>
</div>
</div>
</body>
</html>
