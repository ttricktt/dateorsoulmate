<?php require_once("includes/session.php"); ?>
<?php function display_header() { ?>
<h1>Dateorsoulmate.com</h1>
<p class="tagline">Free Dating Website<span class="float_right">Meet people looking for relationships</span></p>
<table width="800px">
<tr>
<td>
<div id="navcontainer">
<ul>
<li><a href="index.php" id="current">Main</a></li>
<?php if (!isset($_SESSION['valid_id'])) { ?>
<li><a href="register.php">Join</a></li>
<?php } else { ?>
<?php 
// This test is used to check if user has a zipcode in the userinfo table. 
// So after the user registers they still don't see the options below in the main menu.
// The purpose of this test is to hide the below selections until 
// the user puts in their zipcode.
 $row = get_member_info($_SESSION['valid_id']); 
		//took this line out on 12/29/2010
		if (($row[zip]) > 0) {
		?>
<li><a href="inbox.php">Inbox</a></li>       
<li><a href="upload_picture_form.php">My Pictures</a></li>
<li><a href="search.php">Search</a></li>
<?php } ?>
<?php if (isset($_SESSION['valid_id'])) { ?>
<li><a href="my_stuff.php">My Stuff</a></li>
<li><a href="logout.php">Logout</a></li>
<?php } // if (isset($_SESSION['valid_id']))
	}
 ?>
</ul>
</div>
</td>
</tr>
</table>
<?php } ?>