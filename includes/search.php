<?php require_once("session.php"); ?>

<?php
function do_search() {
require_once("upyoursbaby/db_fns.php");
require_once("functions.php");
require_once("header.php");
require_once('zipcode.class.php');      // zip code class

//Connect to database
db_connect();
$valid_id = ($_SESSION['valid_id']);
//$user_zip = $_SESSION['sel_zip'];
$my_zip = get_member_info($valid_id);
//echo $my_zip['zip'];

// Get logged in user zipcode
$sel_member_info = get_member_info($valid_id);
$zip = $sel_member_info[zip];

$z = new zipcode_class;
//$miles = $z->get_distance($zip, $user_zip);

?>




<h2>Search</h2>
<span class="bold">Currently</span>, working on this <span class="bold">search function</span>, guess it would be 	nice to search for people, right?
You'll probably see funky stuff, it's because it's being worked on, remember?
Date expected to be working, hmm, can't say. This is a one person endeavor, but it'll get done.<br /> 

<form id="distance" method="post" action="">
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
<input name="submit" id="submit" type="submit" value="submit">
</form>



<?php

 if (isset($_POST['submit'])) {
	$sel_distance = $_POST[choose];
		
//if ($miles === false) echo 'Error: '.$z->last_error;
//else 


// Below is an example of how to return an array with all the zip codes withing
// a range of a given zip code along with how far away they are.  The array's
// keys are assigned to the zip code and their value is the distance from the
// given zip code.  



$zips = $z->get_zips_in_range($zip, ($sel_distance+1), _ZIPS_SORT_BY_DISTANCE_ASC, true); 

if ($zips === false) echo 'Error: '.$z->last_error;
else {
   
   foreach ($zips as $key => $value) {
	  $row = get_member_zip($key);
	  while ($sel_user = mysql_fetch_array($row)) {
	  ?>
      <ul>
      <li><a href=../search_fn.php?choose_userid=<?php echo $sel_user[valid_id]; ?>>
	  <?php 
	  echo $sel_user[username]; 
	  } ?></a></li>
      </ul>
      
<?php
   }
  
 	$result = count($zipcodes);
   
}
$details = $z->get_zip_details($zip);
}
} //function do_search()

?>


