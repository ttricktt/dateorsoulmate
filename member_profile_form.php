<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php //$userid =  logged_in();?>
<?php $valid_id =  $_SESSION['valid_id'];?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Date Or Soulmate</title>
<link href="/includes/css2.css"  media="all" rel="stylesheet" type="text/css" />
</head>
<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
db_connect();
?>
<body>
<div id="bg_wrap">
<?php
display_header();
?>
<?php //Test for required fields.
if (array_key_exists('submit',$_POST)){
	// Fields that are on form
	$expected = array('states','zip');
	// Set required fields 
	$required = array('states','zip'); 
	// Initialize array for errors 
	$errors = array(); 
			
	foreach ($_POST as $field => $value){
		// Assign to $temp and trim spaces if not array 
		$temp = is_array($value) ? $value : trim($value);
		// If field is empty and required, tag onto $errors array 
		if (empty($temp) && in_array($field, $required)) { 
			array_push($errors, $field); 
		}
	
	}
		//If good to go
	if (empty($errors)){
			$query = ("UPDATE userinfo set
						city='{$city}',
						zip = '{$zip}',
						state = '{$states}',
						seeking = '{$seeking}',
						marital_status = '{$married}',
						lookingfor = '{$relationship}',
						ethnicity = '{$ethnicity}',
						body_type = '{$body_type}',
						height = '{$height}',
						hair_color = '{$hair}',
						drink = '{$drink}',
						smoke = '{$smoke}',
						interest = '{$interest}',
						aboutme = '{$aboutme}',
						First_Date = '{$First_Date}'
						WHERE valid_id=$valid_id ");
						$result = mysql_query($query);
		//echo "Thanks"; exit;
	unset($errors);
	header("location: index.php");
			exit;
	}
}  //(array_key_exists('submit',$_POST))

?>
<div id="content">
<div class="green">Thanks for regerstering. Now, lets fill in your profile.</div>

<form id="member_form"  class="member" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <fieldset>
  <legend>About You</legend>
  <span class="red">* Required</span>
  <?php if (isset($errors) && in_array('city', $errors)){?>
  <div class="red">City</div>
  <?php } ?>
  <label for="city" class="fixedwidth"><span>City</span>
  <input type="text" name="city" id="city" maxlength="50" 
	<?php if (isset($errors)) { echo 'value="'.htmlentities($_POST['city']).'"'; } ?> />
  </label>
  <?php if (isset($errors) && in_array('zip', $errors)){?>
  <div class="red">Zip Code</div>
  <?php } ?>
  <label for="zip" class="fixedwidth"><span>* Zip or Postal Code</span>
  <input type="text" name="zip" id="zip" maxlength="50" 
	<?php if (isset($errors)) { echo 'value="'.htmlentities($_POST['zip']).'"'; } ?> />
  </label>
  <?php
// Where do you live
$states_result = mysql_query("SELECT id, states FROM states");
$states_options="";
while($states_row = mysql_fetch_array($states_result)) {
    $id=$states_row["id"];
    $states=$states_row["states"];
    $states_options.="<OPTION VALUE=\"$id\">".$states;} ?>
  <?php if (isset($errors) && in_array('states', $errors)){?>
  <div class="red">Please choose a state.</div>
  <?php } ?>
  <label id="states" for="states" class="fixedwidth"><span>* State</span>
  <select name=states>
    <option value=0>Choose
      <?=stripslashes($states_options)?>
      </option>
  </select>
  </label>
  <?php
// Get dating from seeking
$seeking_result = mysql_query("SELECT id, seeking FROM seeking");
$seeking_options="";
while($seeking_row = mysql_fetch_array($seeking_result)) {
    $id=$seeking_row["id"];
    $seeking=$seeking_row["seeking"];
    $seeking_options.="<OPTION VALUE=\"$id\">".$seeking;} ?>
  <label for="Looking" class="fixedwidth"><span>Seeking a</span>
  <select name=seeking>
    <option value=0>Choose
      <?=stripslashes($seeking_options)?>
      </option>
  </select>
  </label>
  <?php 
// Get status from married table and fill drop down menu
$married_result = mysql_query("SELECT id, status FROM married");
$married_options="";
while($married_row = mysql_fetch_array($married_result)) {
    $id=$married_row["id"];
    $married=$married_row["status"];
    $married_options.="<OPTION VALUE=\"$id\">".$married;} ?>
  <label for="married" class="fixedwidth"><span>Relationship Status</span>
  <select name=married>
    <option value=0>Choose
      <?=stripslashes($married_options)?>
      </option>
  </select>
  </label>
  <?php
// What I'm looking for in a relationship
$relationship_result = mysql_query("SELECT id, relationship FROM relationship");
$relationship_options="";
while($relationship_row = mysql_fetch_array($relationship_result)) {
    $id=$relationship_row["id"];
    $relationship=$relationship_row["relationship"];
    $relationship_options.="<OPTION VALUE=\"$id\">".$relationship;} ?>
  <label for="Dating" class="fixedwidth"><span>I'm Looking For.</span>
  <select name=relationship>
    <option value=0>Choose
      <?=stripslashes($relationship_options)?>
      </option>
  </select>
  </label>
  <?php
// Get status from ethnicity table and fill drop down menu
$ethnicity_result = mysql_query("SELECT id, ethnicity FROM ethnicity");
$ethnicity_options="";
while($ethnicity_row = mysql_fetch_array($ethnicity_result)) {
    $id=$ethnicity_row["id"];
    $ethnicity=$ethnicity_row["ethnicity"];
    $ethnicity_options.="<OPTION VALUE=\"$id\">".$ethnicity;} ?>
  <label for="ethnicity" class="fixedwidth"><span>My Ethnicity?</span>
  <select name=ethnicity>
    <option value=0>Choose
      <?=stripslashes($ethnicity_options)?>
      </option>
  </select>
  </label>
  <?php
// Get status from body_type table and fill drop down menu
$body_type_result = mysql_query("SELECT id, body_type FROM body_type");
$body_type_options="";
while($body_type_row = mysql_fetch_array($body_type_result)) {
    $id=$body_type_row["id"];
    $body_type=$body_type_row["body_type"];
    $body_type_options.="<OPTION VALUE=\"$id\">".$body_type;} ?>
  <label for="body_type" class="fixedwidth"><span>My Body Type?</span>
  <select name=body_type>
    <option value=0>Choose
      <?=stripslashes($body_type_options)?>
      </option>
  </select>
  </label>
  <?php
// Get height
$height_result = mysql_query("SELECT id, height FROM height");
$height_options="";
while($height_row = mysql_fetch_array($height_result)) {
    $id=$height_row["id"];
    $height=$height_row["height"];
    $height_options.="<OPTION VALUE=\"$id\">".$height;} ?>
  <label for="height" class="fixedwidth"><span>My Height?</span>
  <select name=height>
    <option value=0>Choose
      <?=stripslashes($height_options)?>
      </option>
  </select>
  </label>
  <?php
// Get hair
$hair_result = mysql_query("SELECT id, hair FROM hair");
$hair_options="";
while($hair_row = mysql_fetch_array($hair_result)) {
    $id=$hair_row["id"];
    $hair=$hair_row["hair"];
    $hair_options.="<OPTION VALUE=\"$id\">".$hair;} ?>
  <label for="Hair" class="fixedwidth"><span>Hair Color?</span>
  <select name=hair>
    <option value=0>Choose
      <?=stripslashes($hair_options)?>
      </option>
  </select>
  </label>
  <?php
// Get status from drink table and fill drop down menu
$drink_result = mysql_query("SELECT id, drink FROM drink");
$drink_options="";
while($drink_row = mysql_fetch_array($drink_result)) {
    $id=$drink_row["id"];
    $drink=$drink_row["drink"];
    $drink_options.="<OPTION VALUE=\"$id\">".$drink;} ?>
  <label for="Drink" class="fixedwidth"><span>Do You Drink?</span>
  <select name=drink>
    <option value=0>Choose
      <?=stripslashes($drink_options)?>
      </option>
  </select>
  </label>
  <?php
// Do you smoke
$smoke_result = mysql_query("SELECT id, smoke FROM smoke");
$smoke_options="";
while($smoke_row = mysql_fetch_array($smoke_result)) {
    $id=$smoke_row["id"];
    $smoke=$smoke_row["smoke"];
    $smoke_options.="<OPTION VALUE=\"$id\">".$smoke;} ?>
  <label for="Smoke" class="fixedwidth"><span>Do You Smoke?</span>
  <select name=smoke>
    <option value=0>Choose
      <?=stripslashes($smoke_options)?>
      </option>
  </select>
  </label>
  <br />
  <p class="bold">Description</p>
    <p class="red">For your own safety, do not include your name, phone number or address.</p>
  <label for="interest"></label>
  <span>
  <div class="text_forms">You're interest (hobbies, Music, etc.) separate with commas. </div>
  </span>
  <textarea id="interest" name="interest" cols="40" rows="1"></textarea>
  
  <label for="aboutme"></label>
  <span>
  <div class="text_forms">Please provide a discrption about yourself. Everyone has something good to say.</div>
  </span>
  <textarea id="aboutme" name="aboutme" cols="40" rows="7"></textarea>
  
  <label for="First_Date"></label>
  <span>
  <div class="text_forms">Describe your first date</div>
  </span>
  <textarea id="First_Date" name="First_Date" cols="40" rows="7"></textarea>
  
  
  </fieldset>
  <div id="bubble2">You made it!<br />
You’re almost done, really...<br />
Tell a little about yourself.
This way when someone does a search they can find you.
Don’t be shy; this is where you can talk about yourself & your interest. 
<br />Keep it fun!<br />
After you click<br />submit look on the<br />top menu and add a picture.<br />Everyone likes<br />pictures!   
</div>
  <div>
      <input name="submit" id="submit" type="submit" value="Submit" />
    </div>
    
</form>
<!-- Display welcome girl on right side-->
<div id="right_side_content"><img src="images/welcome_girl_6.png" /></div>
</div>

</div>


</body>
</html>
