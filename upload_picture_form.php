<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php $valid_id =  $_SESSION['valid_id'];?>

<?php
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
require_once("includes/header.php");
db_connect();
?>

<?php
//////////////////////////////////////////////////////////////////////
/////////////// Get pictures for logged in user //////////////////////
///////////////////////////////////////////////////////////////////// 
	$sel_picture_sql = "select * from pictures
 				where user_id = '$valid_id'";
				$sel_picture_result=mysql_query($sel_picture_sql);
				$count=mysql_num_rows($sel_picture_result);
			
////////////////////////////////////////////////////////////////////
// ////////////// End get pictures /////////////////////////////////
////////////////////////////////////////////////////////////////////
				
///////////////////////////////////////////////////////////////////////////////
//////////////// Delete selected pictures for logged in user /////////////////
//////////////////////////////////////////////////////////////////////////////
	if (isset($_POST['deleteormain'])) 
	{
		for ($i=0; $i < $count; $i++) 
	{
			$del_id = $checkbox[$i];
			// Delete files from picture folder on server
			$query = "select * from pictures where picture_id = '$del_id'";
			$result = mysql_query($query);
			$filename_row=mysql_query($query);
			$filename=mysql_fetch_array($filename_row);
			//echo $filename[file_name]; exit;
			if (file_exists("pictures/$filename[file_name]")) 
		{ 
			unlink("pictures/$filename[file_name]");
		}
			// Delete picture file names that were selected.
			$query = "DELETE FROM pictures WHERE picture_id = '$del_id'";
			$result = mysql_query($query);
	}
		if($result)
	{
			// This line will refresh page after pictures are deleted.
			echo "<meta http-equiv=\"refresh\"content=\"0;URL=upload_picture_form2.php\">";
	}
	}
///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// End delete pictures //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

	
	if (isset($_FILES['uploaded_file'])) 
	{
		// Access the $_FILES global variable for this specific file being uploaded
		// and create local PHP variables from the $_FILES array of information
		$fileName = $_FILES["uploaded_file"]["name"]; // The file name
		$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
		$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 = false | 1 = true
		$kaboom = explode(".", $fileName); // Split file name into an array using the dot
		$fileExt = end($kaboom); // Now target the last array element to get the file extension
	// START PHP Image Upload Error Handling --------------------------------------------------
	if (!$fileTmpLoc) { // if file not chosen
		echo "ERROR: Please browse for a file before clicking the upload button.";
		exit();
	} else if($fileSize > 1000000) { // if file size is larger than 5 Megabytes
		echo "ERROR: Your file was larger than 1 Megabytes in size.";
		unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
		exit();
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		// This condition is only if you wish to allow uploading of specific file types    
		echo "ERROR: Your image was not .gif, .jpg, or .png.";
		unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
		exit();
	} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
		echo "ERROR: An error occured while processing the file. Try again.";
		exit();
	}
// END PHP Image Upload Error Handling ----------------------------------------------------

		
	// The complete path/filename
	$fileName = $valid_id . '_' . time() . '_' . $_SERVER['REMOTE_ADDR'] . "." . $fileExt;
	echo $fileName . "<br />";
	
	// Place it into your "uploads" folder mow using the move_uploaded_file() function
	$moveResult = move_uploaded_file($fileTmpLoc, "pictures/$fileName");
	// Check to make sure the move result is true before continuing
	if ($moveResult != true) {
		echo "ERROR: File not uploaded. Try again.";
		unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
		exit();
	}
	unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
	
	// ---------- Include Adams Universal Image Resizing Function --------
	include_once("includes/php_img_lib.php");
	$target_file = "pictures/$fileName";
	$resized_file = "pictures/$fileName";
	$wmax = 400;
	$hmax = 300;
	ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
// ----------- End Adams Universal Image Resizing Function -----------


			$query = "INSERT INTO pictures (
			file_name, user_id
			) VALUES (
			'$fileName',$valid_id)";
			$result = mysql_query($query);
	
		// This line will refresh page after pictures are uploaded.
		if($result){echo "<meta http-equiv=\"refresh\"content=\"0;URL=upload_picture_form2.php\">";}
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image - Upload Form</title>
<link href="includes/css5.css"  media="all" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="bg_wrap">
<?php
display_header();
?>
<div id="content">
<div class="green">Upload pictures.</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
<fieldset>
<legend>Pictures</legend>

<div><label id="uploaded_file">Select picture to upload:<br />
<input type="file" id="uploaded_file" name="uploaded_file"/></label></div>
<div>
<input type="hidden" name="action" value="uploaded_file"/>

<div>
      <input name="submit" id="submit" type="submit" value="Submit" />
    </div>
</form>
<p>Upload files 1 Meg. or smaller.</p>
<p><a target="_blank" href="http://en.wikipedia.org/wiki/File_size">Learn more about file size</a></p>
</fieldset>
<p class="red">Please, no nude pictures. Nude images will be deleted and user account will be deleted.</p>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<legend>Edit Pictures</legend>
<?php while($sel_picture=mysql_fetch_array($sel_picture_result)) { ?>
<ul>
<li><img src = imageresize2.php?image=pictures/<?php echo $sel_picture[file_name]; ?>>
<div><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $sel_picture[picture_id]; ?>" />Delete</div>

<!-- input type="radio" name="main" />Main</li>-->
</ul>
<?php } ?>

      <input name="deleteormain" id="deleteormain" type="submit" value="Edit" />
    
</form>


</div>

</div>

</body>
</html>
