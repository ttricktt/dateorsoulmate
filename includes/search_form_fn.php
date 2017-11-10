<?php function display_search_form() { ?>
<?php
$valid_id = ($_SESSION['valid_id']); // Get logged in user that is logged in
$sel_member_info = get_member_info($valid_id); // Get ready to catch logged in users zipcode
		$zip = $sel_member_info['zip']; //Get logged in users zip code
		$z = new zipcode_class; // part of zipcode.class.php

?>
<!--Search form-->
<form id = "search_form" class = "member" method = "post" action = <?php echo$_SERVER['PHP_SELF']; ?> >
<?php
// Get dating from seeking
$seeking_result = mysql_query("SELECT id, seeking FROM seeking");
$seeking_options="";
	while($seeking_row = mysql_fetch_array($seeking_result)) {
		$id=$seeking_row["id"];
		$seeking=$seeking_row["seeking"];
		$seeking_options.="<OPTION VALUE=\"$id\">".$seeking;
	} ?>

Seeking a
<select name="seeking">
<option VALUE="0">Choose<?=stripslashes($seeking_options)?>
</select>
Miles from me
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
Age
From<input type="text" name="age1" id="age1" size="3" maxlength="3"/>
To<input type="text" name="age2" id="age2" size="3" maxlength="3"/>
<input name="submit" id="submit" type="submit" value="submit">
</form>
</div>

<?php
 if (isset($_POST['submit'])) {
	// Assign posted age range
	mysql_prep($age1 = $_POST['age1']);
	$age2 = $_POST[age2];
	// if age fields left blank assign variables or non int reassign age range
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
			<?php echo $row[username]; ?>
<?php	
			}		
		} //foreach ($zips as $key => $value)
	} //else	
}
?>
<?php } // end function ?> 