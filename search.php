<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php //error_reporting(E_ALL); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="MRzwQ68HOgXdPcJOTSYArQXWOuCu_IaFiaeoZydkQio" />
<title>Dateorsoulmate.com search page</title>
<link href="includes/css2.css"  media="all" rel="stylesheet" type="text/css" />
</head>
<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
require_once('includes/zipcode.class.php');      // zip code class

//Connect to database
db_connect();

$valid_id = ($_SESSION['valid_id']); // Get logged in user that is logged in
$sel_member_info = get_member_info($valid_id); // Get ready to catch logged in users zipcode

$zip = $sel_member_info['zip']; //Get logged in users zip code
$z = new zipcode_class; // part of zipcode.class.php

 //this test is used to catch member info after clicked from the leftside of users.

	if (isset($_GET['choose_userid'])) {
	$sel_userid = $_GET['choose_userid'];
	$row = get_member_info($sel_userid);
	$sel_state = get_state($row[state]);
		$sel_zip = ($row[zip]);
		$sel_seeking = get_seeking($row[seeking]);	
		$sel_username = $row[username];
		$sel_age = $row[age];
		$sel_interest = $row[interest];
		$sel_aboutme = $row[aboutme];
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
	} else {
			$sel_userid = "";
	}
?>
<body>
<div id="bg_wrap">
<div id="header">
<?php display_header(); ?>
</div>


<!--Search form-->
<div id="search_form2">
<form id = "search_form" class = "member" method = "post" action = <?php echo$_SERVER['PHP_SELF']; ?> >
<!--fieldset-->

<?php
// Get dating from seeking
$seeking_result = mysql_query("SELECT id, seeking FROM seeking");
$seeking_options="";

	while($seeking_row = mysql_fetch_array($seeking_result)) {
		$id=$seeking_row["id"];
		$seeking=$seeking_row["seeking"];
		$seeking_options.="<OPTION VALUE=\"$id\">".$seeking;
	} ?>

<!--label for="Looking"-->Seeking a
<select name="seeking">
<option VALUE="0">Choose<?=stripslashes($seeking_options)?>
</select>
<!--/label-->

<!--label for="distance"-->Miles from me
<select name="choose">
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="75">75</option>
<option value="100">100</option>
<option value="125">125</option>
<option value="150">150</option>
</select> 
<!--/label-->

<!--label for="age"-->Age
From<input type="text" name="age1" id="age1" size="3" maxlength="3"/>
To<input type="text" name="age2" id="age2" size="3" maxlength="3"/>
<!--/label-->


<input name="submit" id="submit" type="submit" value="submit">
<!--/fieldset-->
</form>
</div>
<div id="content_search">

<?php

 if (isset($_POST['submit'])) {
 
	// if age fields left blank assign variables
	if (($_POST[age1] == "") or (!intval($_POST[age1]))) $age1 =18;
	if (($_POST[age2] == "") or (!intval($_POST[age2]))) $age2 =99;
	
		$sel_seeking = $_POST[seeking];
		$sel_distance = $_POST[choose];
		
	

// Below is an example of how to return an array with all the zip codes withing
// a range of a given zip code along with how far away they are.  The array's
// keys are assigned to the zip code and their value is the distance from the
// given zip code.  
$zips = $z->get_zips_in_range($zip, ($sel_distance+1), _ZIPS_SORT_BY_DISTANCE_ASC, true); 

	if ($zips === false) echo 'Error: '.$z->last_error;
		 else {
	foreach ($zips as $key => $value) {
	
				$sel_zip = get_member_zip($key); //get_member_zip is in functions.php
				$query = 	"select userinfo.username, userinfo.valid_id, userinfo.age, userinfo.gender, "
							. "pictures.user_id, pictures.file_name "
							. "from userinfo LEFT JOIN pictures "
							. "ON userinfo.valid_id = pictures.user_id "
							. "where userinfo.zip = {$key} "
							. "and userinfo.seeking = {$sel_seeking} "
							. "and userinfo.age between {$age1} and {$age2} "
							. "LIMIT 1" //Displays one picture per user
							;
				//echo "$query <br />";exit;
				$member_info = mysql_query($query);
				if (!$member_info) {
					die("Datebase query failed: " . mysql_error());
					}
								
			while ($row = mysql_fetch_array($member_info)) {
				//if (($row[valid_id]) <> null) {
				
			
		?>	
			
			
			<a href=search.php?choose_userid=<?php echo urlencode($row[valid_id]); ?>>
			<img src = imageresize2.php?image=pictures/<?php echo $row[file_name]; ?>></a>
		<?php	
				echo $row[username];
				echo "<br />";
			
			
			//}		
						
		}		
	} //foreach ($zips as $key => $value)	
	
	} //else	
}
?>

<!-- put found users above this line -->


<?php
	if (isset($_GET['choose_userid'])) { //If user is clicked then show
		echo "<DIV id=\"description\">";
		
			echo "<table class=\"user_description\">";
			
			echo "<tr>";
			
			echo "<td class=\"black\">About " . $sel_username . "</td>";
			echo "<td class=\"black\">Age " . "<span class=\"about\">" . $sel_age . "</span></td>";
			echo "<td class=\"black\">State " . "<span class=\"about\">" . $sel_state[states] . "</span></td>";
			
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"black\">I'm a " . "<span class=\"about\">" . $sel_gender[male_female] . "</span></td>";
			echo "<td class=\"black\">Relationship status " . "<span class=\"about\">" . $sel_relationship_status[status] . "</td>";
			echo "<td class=\"black\">Ethnicity " . "<span class=\"about\">" . $sel_ethnicity[ethnicity] . "</span></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"black\">Looking for " . "<span class=\"about\">" . $sel_seeking[seeking] . "</span></td>";
			echo "<td class=\"black\">For " . "<span class=\"about\">" . $sel_dating[relationship] . "</span></td>";
			echo "<td class=\"black\">Height " . "<span class=\"about\">" . $sel_height[height] . "</span></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"black_bold\" colspan=\"3\">About <span class=\"about\">" . $sel_aboutme . "</span></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"black_bold\" colspan=\"3\">First Date <span class=\"about\">" . $sel_First_Date . "</span></td>";
			echo "</tr>";
			echo "</table>";
			
		if(isset($_SESSION['valid_id'])) { // this will show the send message box if user is logged in
			?>
			<TABLE class="user_description">
            <FORM id="message" class="message_form"  method="post" action="">
            	<LEGEND>Send <?php echo $sel_username; ?> a message.</LEGEND>
				<LABEL for="message"></LABEL>
			  	<TR>
                	<TH>Subject</TH>
					<TH>Message</TH>
                </TR>
                <TR>
                	<TD><INPUT type="text" name="subject" id="subject" maxlength="200"/></TD>
					<TD><TEXTAREA id="message" name="message" cols="60" rows="3"></TEXTAREA></TD>
					<TD><INPUT name="SendMessage" id="SendMessage" type="submit" value="Send" /></TD>
                </TR>
			</table>
				
    		</FORM>
			
			<?php
				if (isset($_POST['SendMessage'])) {
					send_a_message($sel_userid,$_POST['subject'],$_POST['message']);
						if (isset($result)) {
						echo "Message Sent";
					}
				}
			?>
            
<?php	
		}
			

			echo "<DIV id=\"description\">";
			echo "<table>";
				echo "<tr>";
					while($sel_picture=mysql_fetch_array($sel_picture_result)) {
						if ($sel_picture[ok_to_show]==1) {
				echo "<td>";
				$counter += 1;
				if ($counter ==5) {
					echo "<tr>";
					$counter = 0;
					} 
				echo "<img class=\"imgborder\" src=imageresize_large.php?image=pictures/" . $sel_picture[file_name] . " " . "alt=\"dating\"";
				echo "</td>";
				} //if ($sel_picture)
			} //while($sel_picture=mysql_fetch_array($sel_picture_result))
				
				echo "</tr>";
			echo "</table>";
			echo "</div>";
?>
			</TABLE>

<?php } ?>

</div>
</div>

</body>
</html>


