<?php
// include function files for this application
require_once("upyoursbaby/db_fns.php");
require_once("includes/functions.php");
//require_once("html_header.php");

session_start();

$_SESSION = array();

if(isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '' , time()-42000, '/');
	}

session_destroy();
header("location: index.php");
?>