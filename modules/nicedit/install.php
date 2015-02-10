<?php 
$mod_uuid="000001";
$mod_name="NicEdit Textarea Editor";
$mod_type="UI";
$mod_data_placement="html_head";
 
$sql="INSERT INTO $database.modules values (NULL,'$mod_uuid','$mod_name','$mod_type','$mod_data_placement','enabled','installed')";

$result= sendquery($sql,"");

?>

