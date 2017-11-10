<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php echo "<a href=index.php?choose_userid="; ?><?php echo urlencode($choose_userid) . " />"; ?><?php echo urlencode($username) ?><br />
<a href="index.php?choose_userid=<?php urlencode($choose_userid); ?><?php echo urlencode($username); ?>" />
<a href="index.php?choose_userid=<?php urlencode($choose_userid); ?>" />

	<?php echo "<a href=index2.php?choose_userid="; ?><?php echo urlencode($choose_userid) . " />"; ?><?php echo urlencode($username) ?><br />
	<?php echo urlencode($gender[male_female]); ?>
    <img class="imgborder" src="imageresize2.php?image=pictures/<?php echo $picture[file_name];?>" alt="dating" />
    <a href="index.php?choose_userid=<?php echo urlencode($choose_userid);?>" />
    <img src="imageresize2.php?image=pictures/<?php echo $picture[file_name];?>" alt="dating" /><br />
    <a href="index.php?choose_userid=<?php echo $choose_userid ?>" />
     <a href="http://www.w3schools.com">Visit W3Schools.com!</a>
</body>
</html>
