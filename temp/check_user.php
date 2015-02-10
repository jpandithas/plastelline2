<?php 

$host=$_POST['host'];
$db_user=$_POST['db_user'];
$db_pass=$_POST['db_pass'];

$connect=mysql_connect($host,$db_user,$db_pass);

if (!$connect) { echo "0";} else {echo "1";}

?>
