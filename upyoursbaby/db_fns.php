<?php

//1. Create a database connection
function db_connect() {
$connection = mysqli_connect("mysql","project","secret");
if (!$connection)  {
	die("Database connection failed: " . mysql_connect_error());
	}

// 2. Select a database to use
$db_select = mysqli_select_db($link, 'project');
if (!$db_select)  {
	die("Database selection failed: " . mysql_connect_error());
	}
}
	


?>