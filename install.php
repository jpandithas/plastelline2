<?php
session_start(); 

include("includes/install_core.php"); 

$post_status=$_POST['step'];

if (!isset($post_status)) {
        $_SESSION[]="";
	$post_status="step1";
	}
	
switch ($post_status) {

	case "step1": 
	inst_step_1(); 
	break;
	
	case "step2":
	inst_step_2(); 
	break;
	
	case "step3":
	inst_step_3();
	break;

	case "done":
	header("Location:$home_scr");
	break; 

} 
 
 
?>
