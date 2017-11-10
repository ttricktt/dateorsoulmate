<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php //$userid =  logged_in();?>
<?php $valid_id =  $_SESSION['valid_id'];?>
<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
db_connect();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="includes/css5.css" rel="stylesheet" type="text/css"/>
<title>Date Or Soulmate My stuff</title>
</head>

<body>
<div id="bg_wrap">
<?php display_header(); ?>
<?php //Test for required fields.

if (array_key_exists('submit',$_POST)){

	// Fields that are on form
	$expected = array('states','zip','seeking','married','ethnicity','body_type','height','hair','aboutme');
	// Set required fields 
	$required = array('states','zip','seeking','married','ethnicity','body_type','height','hair','aboutme'); 
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
						
						zip = '{$zip}',
						state = '{$states}',
						seeking = '{$seeking}',
						lookingfor = '{$relationship}',
						marital_status = '{$married}',
						ethnicity = '{$ethnicity}',
						body_type = '{$body_type}',
						height = '{$height}',
						hair_color = '{$hair}',
						drink = '{$drink}',
						smoke = '{$smoke}',
						aboutme = '{$aboutme}',
						interest = '{$interest}'
						WHERE valid_id=$valid_id ");
						//echo $query; exit;
						$result = mysql_query($query);
		//echo "Thanks"; exit;
	unset($errors);
	header("location: index.php");
			exit;
	}
	$selectstate = htmlentities($_POST['states']);
	$selectseeking = htmlentities($_POST['seeking']);
	$selectrelationship = htmlentities($_POST['relationship']);
	$selectmarried = htmlentities($_POST['married']);
	$selectethnicity = htmlentities($_POST['ethnicity']);
	$selectbody_type = htmlentities($_POST['body_type']);
	$selectheight = htmlentities($_POST['height']);
	$selectdrink = htmlentities($_POST['drink']);
	$selectsmoke = htmlentities($_POST['smoke']);
	$selecthair = htmlentities($_POST['hair']);
	$selectaboutme = htmlentities($_POST['aboutme']);
	$selectinterest = htmlentities($_POST['interest']);
	
}  //(array_key_exists('submit',$_POST))

//////////////////////////////////////////////////////////////////
// Get records from tables that we will use in drop down fields //
//////////////////////////////////////////////////////////////////
$states_result = mysql_query("SELECT id, states FROM states");
$seeking_result = mysql_query("SELECT id, seeking FROM seeking");
$married_result = mysql_query("SELECT id, status FROM married");
$relationship_result = mysql_query("SELECT id, relationship FROM relationship");
$ethnicity_result = mysql_query("SELECT id, ethnicity FROM ethnicity");
$body_type_result = mysql_query("SELECT id, body_type FROM body_type");
$height_result = mysql_query("SELECT id, height FROM height");
$hair_result = mysql_query("SELECT id, hair FROM hair");
$drink_result = mysql_query("SELECT id, drink FROM drink");
$smoke_result = mysql_query("SELECT id, smoke FROM smoke");



?>
<div id="wrapper">
	<div id="inner-wrapper">
<div class="green">Thanks for regerstering. Now, lets fill in your profile.</div>
<form id="member_form"  class="member" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <br />
  <span class="red">* Required</span>
  <br />
  
  <table>
  
  <?php if (isset($errors) && in_array('states', $errors)){?>
  <div class="red">State</div>
	<?php } ?>
	<tr>
  <td><span>* State</span></td>
  <td>
  <select name="states" id="states">
  <option value="0"></option>
    <?php
	while($states_row = mysql_fetch_array($states_result)) {
    $id=$states_row["id"];
    $states=$states_row["states"];
	echo "<option value=".$id; 
	if ($selectstate==$id) echo " selected ";
	echo ">" . $states . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
  <?php if (isset($errors) && in_array('zip', $errors)){?>
  <div class="red">Zip Code</div>
  <?php } ?>
  <tr>
  <td><span>* Zip or Postal Code</span></td>
  <td>
	<input type="text" name="zip" id="zip" maxlength="50" 
	<?php if (isset($errors)) { echo 'value="'.htmlentities($_POST['zip']).'"'; } ?> />
	</td>
  </tr>
 
 
    <?php if (isset($errors) && in_array('seeking', $errors)){?>
	<div class="red">Seeking</div>
	<?php } ?>
	 <tr>
	 <td><span>* Seeking</span></td>
	 <td>
	<select name=seeking>
	<option value="0"></option>
    <?php
	while($seeking_row = mysql_fetch_array($seeking_result)) {
    $id=$seeking_row["id"];
    $seeking=$seeking_row["seeking"];
	echo "<option value=".$id; 
	if ($selectseeking==$id) echo " selected ";
	echo ">" . $seeking . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
  <?php if (isset($errors) && in_array('relationship', $errors)){?>
	<div class="red">Dating</div>
	<?php } ?>
	 <tr>
	 <td><span>* Dating</span></td>
	 <td>
	<select name=relationship>
	<option value="0"></option>
    <?php
	while($relationship_row = mysql_fetch_array($relationship_result)) {
    $id=$relationship_row["id"];
    $relationship=$relationship_row["relationship"];
	echo "<option value=".$id; 
	if ($selectrelationship==$id) echo " selected ";
	echo ">" . $relationship . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
  <?php if (isset($errors) && in_array('married', $errors)){?>
	<div class="red">Relationship Status</div>
	<?php } ?>
	 <tr>
	 <td><span>* Relationship Status</span></td>
	 <td>
	<select name="married">
	<option value="0"></option>
    <?php
	while($married_row = mysql_fetch_array($married_result)) {
    $id=$married_row["id"];
    $married=$married_row["status"];
	echo "<option value=".$id; 
	if ($selectmarried==$id) echo " selected ";
	echo ">" . $married . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
  <?php if (isset($errors) && in_array('ethnicity', $errors)){?>
	<div class="red">Ethnicity</div>
	<?php } ?>
	 <tr>
	 <td><span>* Ethnicity</span></td>
	 <td>
	<select name="ethnicity">
	<option value="0"></option>
    <?php
	while($ethnicity_row = mysql_fetch_array($ethnicity_result)) {
    $id=$ethnicity_row["id"];
    $ethnicity=$ethnicity_row["ethnicity"];
	echo "<option value=".$id; 
	if ($selectethnicity==$id) echo " selected ";
	echo ">" . $ethnicity . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
    <?php if (isset($errors) && in_array('body_type', $errors)){?>
	<div class="red">Body Type</div>
	<?php } ?>
	 <tr>
	 <td><span>* Body Type</span></td>
	 <td>
	<select name="body_type">
	<option value="0"></option>
    <?php
	while($body_type_row = mysql_fetch_array($body_type_result)) {
    $id=$body_type_row["id"];
    $body_type=$body_type_row["body_type"];
	echo "<option value=".$id; 
	if ($selectbody_type==$id) echo " selected ";
	echo ">" . $body_type . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
     <?php if (isset($errors) && in_array('height', $errors)){?>
	<div class="red">Height</div>
	<?php } ?>
	 <tr>
	 <td><span>* Height</span></td>
	 <td>
	<select name="height">
	<option value="0"></option>
    <?php
	while($height_row = mysql_fetch_array($height_result)) {
    $id=$height_row["id"];
    $height=$height_row["height"];
	echo "<option value=".$id; 
	if ($selectheight==$id) echo " selected ";
	echo ">" . $height . "</option>";
	} ?>
  </select>
  </td>
  </tr>
  
  
      <?php if (isset($errors) && in_array('hair', $errors)){?>
	<div class="red">Hair</div>
	<?php } ?>
	 <tr>
	 <td><span>* Hair</span></td>
	 <td>
	<select name="hair">
	<option value="0"></option>
    <?php
	while($hair_row = mysql_fetch_array($hair_result)) {
    $id=$hair_row["id"];
    $hair=$hair_row["hair"];
	echo "<option value=".$id; 
	if ($selecthair==$id) echo " selected ";
	echo ">" . $hair . "</option>";
	} ?>
  </select>
  </td>
  </tr>

	 <tr>
	 <td><span>Drink</span></td>
	 <td>
	<select name="drink">
	<option value="0"></option>
	<?php
	while($drink_row = mysql_fetch_array($drink_result)) {
	$id=$drink_row["id"];
	$drink=$drink_row["drink"];
	echo "<option value=".$id; 
	if ($selectdrink==$id) echo " selected ";
	echo ">" . $drink . "</option>";
	} ?>
	</select>
	</td>
	</tr>
  
	 <tr>
	 <td><span>Smoke</span></td>
	 <td>
	<select name="smoke">
	<option value="0"></option>
	<?php
	while($smoke_row = mysql_fetch_array($smoke_result)) {
	$id=$smoke_row["id"];
	$smoke=$smoke_row["smoke"];
	echo "<option value=".$id; 
	if ($selectsmoke==$id) echo " selected ";
	echo ">" . $smoke . "</option>";
	} ?>
	</select>
	</td>
	</tr>  
  </table>
  <table>
    <tr>
    <td class="red">For your own safety, do not include your name, phone number or address.</td>
	</tr>
	<tr><td><span class="red">* Required</span></td></tr>
	<?php if (isset($errors) && in_array('aboutme', $errors)){?>
  <tr><td><div class="red">About Me</div></tr></td>
  <?php } ?>
  <tr>
  <td>* Tell a little about yourself.</td>
  </tr>
  <tr>
  <td><textarea id="aboutme" name="aboutme" cols="65" rows="7">
  <?php if (isset($errors)) { echo $_POST[aboutme];
	} else {
			echo "$selectaboutme";
	} ?>
  </textarea></td>
  </tr>


<tr>
  <td>You're interest (hobbies, Music, etc.) separate with commas.</td>
  </tr>
  <tr>
  <td><textarea id="interest" name="interest" cols="65" rows="2">
    <?php if (isset($errors)) { echo htmlentities($_POST[interest]);
	} else {
			echo htmlentities($selectinterest);
	} ?>
  </textarea></td>
  </tr>
  </table>
  
  
  





  <div>
      <input name="submit" id="submit" type="submit" value="Submit" />
    </div>
    
</form>
</div>
</div>
</div>


</body>
</html>
