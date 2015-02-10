<?php
//start the session handler
session_start(); 
//include the objects library file
//include ("includes/links.php");
global $t_content;
include "includes/forms.php";
include "includes/router.php";
include ("includes/themeinc.php");
include ("includes/mysql.php");
//db_exists();

Router::getModule();
//setup $t_content
//function to parse the user action in $_GET
//read_action();
//define a new object called link

include ("style/theme.php");

?>
