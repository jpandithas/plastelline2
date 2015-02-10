<?php 

$file_d=file('settings/settings.php');

$db_host="localhost";

foreach ($file_d as $key => &$value) {
if (stristr($value,'$host')) { 
$value="\$host=\"$db_host\";";
echo "done!";
break;} else {echo "error";}
}

file_put_contents('settings/active_settings.php',$file_d);
 ?>
