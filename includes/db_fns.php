<?php

//1. Create a database connection
function db_connect() {
$connection = mysql_pconnect("servername","database","mypassword");
if (!$connection)  {
	die("Database connection failed: " . mysql_error());
	}

// 2. Select a database to use
$db_select = mysql_select_db("database");
if (!$db_select)  {
	die("Database selection failed: " . mysql_error());
	}
}

?>