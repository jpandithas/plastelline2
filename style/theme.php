<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
<link href='style/style.css' rel='stylesheet' type='text/css' />
<?php global $status; ?>
<title><?php print_title($ctype,$id)?> </title>

</head>

<body>
<div id="outer">
 <div id="container">
 
 <div id="header"> 
   <div id="header-logo">
   <span id='sitename'><h1>PLASTELINE - SITE NAME</h1></span> <?php // print_logo($t_logo)?>
   </div>
   Plasteline HEADER AREA<?php // print_header($t_header)?>
 </div>
 
 <div id="sidebar-left" class="content"> <?php print_sidebar()?> </div>
   <div id="statusbar"> <font color='Magenta'>Plasteline Says:</font><?php read_status($status)?> </div>
   <div id="content"> <?php print_content($t_content)?> </div>

  
 <div id="footer">
 FOOTER <?php // print_footer($t_footer)?>
 </div>
 
 </div>
 
</div>
</body>

</html>
