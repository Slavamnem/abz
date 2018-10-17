<?php
ini_set('error_reporting', 1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-type: text/html; charset=utf-8");

// Configuring a database connection
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'TestTask'); 
//////////////////////////////////////

$db = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
mysqli_select_db($db, DB_NAME);
mysqli_query ($db,"set_client='utf8'");
mysqli_query ($db,"set character_set_results='utf8'");
mysqli_query ($db,"set collation_connection='utf8_general_ci'");
mysqli_query ($db,"SET NAMES utf8");
mysqli_set_charset($db,'utf8');
?>