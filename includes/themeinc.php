<?php 
include ("login.php");
include ("talkbox.php");
function print_sidebar() {

    if (!empty($_GET)) {
        $i_status=$_GET['status'];
    }
    else
    {
        $i_status=0;
    }
//setup the navigation block 
//talkbox();
$code = "<span id='sidebar-header'> <b>Navigation</b> </span>";
$code .="<ul id='sidebar'> ";
$code .= "<li><a href='index.php'>Home</a></li>";
$code .= "<li><a href=''>Link2</a></li>";
$code .= "<li><a href=''>Link3</a></li>";
$code .= "<li><a href=''>Link4</a></li>";
$code .= "</ul>";
//setup the Categories block 
$code .= "<span id='block-header'> <b>Product Categories</b> </span>";
$code .="<ul id='sidebar'> ";
$sql="SELECT cat_id,cat_name FROM product_categories"; 
$category_result=sendquery($sql,1);
$count=count($category_result);// count how many results only ROWS

for ($i=0;$i<$count;$i++) {
 $link_id=mysql_result($category_result,$i,0);
 $link_name=mysql_result($category_result,$i,1);
 //build the links to each category
 $code .= "<li><a href='?action=display&type=category&id=$link_id'>".$link_name."</a></li>";
 }
$code .= "</ul>";
//setup the admin links block
if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2)) {
$code .= "<span id='sidebar-header'> <b>Admin Links</b> </span>";
$code .="<ul id='sidebar'> ";
$code .= "<li><a href='index.php?action=add&type=page'>Add Web Page Content</a></li>";
$code .= "<li><a href=''>Admin Link2</a></li>";
$code .= "<li><a href=''>Admin Link3</a></li>";
$code .= "<li><a href=''>Admin Link4</a></li>";
$code .= "</ul>";}
print($code);
//check if user has logged in and belongs to an admin class
//if not, display the login screen
 if (isset($_SESSION['u_class'])) { 
  $extra_code.="<br><span id='sidebar-header'> <b><i>USER: </i></b>".$_SESSION['u_name']."</span>";
  $extra_code .="<ul id='sidebar'> ";
  $extra_code.="<li><a href=index.php?action=logout>LOGOUT</a></li>";
  $extra_code .= "</ul>";
  print ($extra_code);
  } else {login();}
}//end sidebar function


function print_content ($_tcontent){
print ($_tcontent); 
}//endfunction

//Function that reads the status flags in url and responds
function read_status($i_status) {
global $t_content;
 switch ($i_status) {
   case 0:
   $status_return="<b>All OK</b>"; 
   echo $status_return;
   break;
   case 1:
   $status_return="<b>Initial Status</b>"; 
   echo $status_return;
   break;
   case 2: 
   $status_return= "<b> You have been Redirected</b>";
   echo $status_return;
   break;
   case 3:
   $status_return= "<b> It could have been a 404 error!</b>";
   $t_content.=$_SESSION['t_content'];
   echo $status_return; 
   break;
   case 4:
   $status_return= "<b> Login Error! Either username or password missing!</b>";
   echo $status_return; 
   break;
   case 5:
   $status_return= "<b> You have logged in! Welcome: ".$_SESSION['u_name']."!</b>";
   echo $status_return; 
   break;
   case 6:
   $status_return= "<b> You Need to login first!</b>";
   echo $status_return; 
   break;
   case 7:
   $status_return= "<b> You have sucessfully logged out! Thanks!</b>";
   $t_content.="<br><h3><center>Thanks for using our system...<br>Really!</center></h3>";
   echo $status_return; 
   break;
   case 8:
   $status_return= "<b> Deleted Successfuly!</b>";
   echo $status_return; 
   break;
   case 9:
   $status_return= "<b> Could not find that page..</b>";
   echo $status_return; 
   break;
   default:
   $status_return= "<b>Undefined status!</b>";
   echo $status_return;
 }
}

//Function that prints the tile of the page accroding to its type
//the ID will be removed and substituted with TITLE
function print_title($ctype,$id) {
	switch ($ctype) {
	 case "page":
	 $sql="SELECT wtitle FROM web_content WHERE wcid=$id";
	 $tdata=sendquery($sql);
	 $title_prefix=$tdata['wtitle'];
	 $title="PAGE | ".$title_prefix;
	 echo $title;
	 break;
	 case "category":
	 $sql="SELECT cat_name FROM product_categories WHERE cat_id=$id";
	 $tdata=sendquery($sql);
	 $title_prefix=$tdata['cat_name'];
	 $title="PRODUCT CATEGORY | ".$title_prefix;
	 echo $title;
	 break;
	 case "product":
	 $title="product with ID: ".$id;
	 echo $title;
	 break;
	default:
	 echo "ESHOP NAME";//ADD eshop name later 
	}
}

?> 
