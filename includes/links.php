<?php 


class url {
  //declare the property action
  var $action;
  //status is another property of url class
  var $status;
  //declare the status property
  //set the action
  var $type;
  var $id;
  //setter function example for action
   function set_action($new_action) {
   $this->action = $new_action;}
   function set_status($new_status) {
   $this->status = $new_status;}
   //setter function example for type
   function set_type($new_type) {
   $this->type = $new_type;}
 //return the action property
   function get_action() {
   return $this->action;}
 //method to push urls by GET
  function push_url($action_new, $status_new,$type_new,$id_new){
  $this->action= $action_new;
  $this->status= $status_new;
  $this->type=$type_new;
  $this->id=$id_new;
   if (($action_new=="display")and ($status_new=="1")) {
   $home_scr=$_SERVER['PHP_SELF'];
   header("Location:$home_scr"."?action=&status=0&type=$type_new");
   }
  }
}




//***reads the action and decides what to do (Usually, Redirects)
//***the main brain behind the whole engine 
//***some parts of the code here should check for login and userclass
function read_action() {
global $t_content; 
  //read from GET directly! vars here are LOCAL
if (!empty($_GET))
{
$page_action=@$_GET['action'];
$content_type=@$_GET['type'];
$content_id=@$_GET['id'];
}
    else
    {
        $page_action="";
    }
//start taking down the url bit by bit
 switch ($page_action) {
  case "train":
   switch ($content_type) {
   case "chat":
   break; 
   case "commands":
    $t_content.="<h2>Teach me, master!</h2>";
	$t_content.="<p>Word to the wise: Words that belong to the same group INTERACT. They provide coherence and balance to the force (...who knows..) Hence it makes sense that you should edit by groups.</p>";
	$sql="SELECT wordname, wordgroup from layer1 where tier_id=1";
	$data=sendquery($sql,1);
	$rows=mysql_num_rows($data); 
	$form= "<table><tr> <td>";
	$form.="<br>Tier 1 Data (Actions)<br>";
	$form.="<table border='1'><tr><td>Word</td><td>Group</td></tr>";
	for ($i=0;$i<$rows;$i++) {
	 $wordname=mysql_result($data,$i,0);
	 $wordgroup=mysql_result($data,$i,1);
	 $form.= "<tr><td>$wordname</td> <td>$wordgroup</td></tr>";}
	 $form.="</table>";
	 $form.="</td>";
	//tier 2 data
	$sql="SELECT wordname, wordgroup from layer1 where tier_id=2";
	$data=sendquery($sql,1);
	$rows=mysql_num_rows($data); 
	$form.="<td>";
	$form.="<br>Tier 2 Data (Content Types)<br>";
	$form.="<table border='1'><tr><td>Word</td><td>Group</td></tr>";
	for ($i=0;$i<$rows;$i++) {
	 $wordname=mysql_result($data,$i,0);
	 $wordgroup=mysql_result($data,$i,1);
	 $form.= "<tr><td>$wordname</td> <td>$wordgroup</td></tr>";}
	 $form.="</table>";
	 $form.="</td>";
	 //tier 3 data 
	$sql="SELECT wordname, reference_wordname, reference_id, wordgroup from layer1 where tier_id=3";
	$data=sendquery($sql,1);
	$rows=mysql_num_rows($data); 
	$form.="<td>";
	$form.="<br>Tier 3 Data (Synonyms)<br>";
	$form.="<table border='1'><tr><td>Word</td><td>Reference</td><td>Reference ID</td><td>Group</td></tr>";
	for ($i=0;$i<$rows;$i++) {
	 $wordname=mysql_result($data,$i,0);
	 $reference_wordname=mysql_result($data,$i,1);
	 $reference_id=mysql_result($data,$i,2);
	 $wordgroup=mysql_result($data,$i,3);
	 $form.= "<tr><td>$wordname</td> <td>$reference_wordname</td> <td>$reference_id</td> <td>$wordgroup</td> </tr>";} 
	  $form.="</table>";
	  $form.="</td></tr></table>";
	 $t_content.=$form; 
	
	 
   break;
   } // end case for action=train
  break;
  case "logout":
   include"modules/mod_logout/mod_logout.php";
   logout();
  break; 
  case "edit": //edit page pretty much looks like add page but the fields are not empty 
   switch ($content_type) {
    case "page":
    if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2))  { 
      $sql="SELECT * FROM web_content WHERE wcid=$content_id" or die(mysql_error()); 
      $page_data=sendquery($sql);
      $edit_wcid=$page_data['wcid'];
      $edit_content=$page_data['content'];
      $edit_alias=$page_data['alias'];
      $edit_wtitle=$page_data['wtitle'];
      //check if submit button has been pressed in the form
      $submit_page=$_POST['Submit'];
      $page_data=$_POST['body_text'];
      $window_title=$_POST['wtitle'];
      $page_id=$_POST['pid'];
      $alias=$_POST['alias'];
      if ($submit_page=="Submit") { 
       $sql="UPDATE web_content SET  content='$page_data', alias='$alias', wtitle='$window_title' WHERE wcid=$page_id";
       $result=mysql_query($sql) or die (mysql_error());
       header("Location:$home_scr"."?action=display&type=page&id=".$page_id); } 
       else {
      //$form=var_dump($_POST);
       $form.="
     <script type='text/javascript' src='http://js.nicedit.com/nicEdit-latest.js'></script> 
     <script type='text/javascript'>
      //<![CDATA[
      bkLib.onDomLoaded(function() {
       new nicEditor({fullPanel : true}).panelInstance('text_editor');
                                   });
      //]]>
  </script>
  <form action='' method='post'>
     <em><b>Window title</b></em></br><input name='wtitle' type='text' style='width:100%' id='wtitle' required='required' value='$edit_wtitle'></br>
     <em><b>Page Content</b></em></br><textarea name='body_text' cols='84' rows='10' id='text_editor' required='required' >$edit_content</textarea></br>
     <em><b>Alias/Link</b></em></br><input name='alias' type='text' required='required' value='$edit_alias' >
     <input type='hidden' name='pid' value='$edit_wcid'>
     <input type='submit' name='Submit' value='Submit'>
     </form>";
     $t_content=$form; } 
     } 
     else {header("Location:index.php?status=6");}
    break; 
    } //end case for page edit 
  break; //end case for edit mode in general
  //delete fucntion for various content types
  case "delete": 
  switch ($content_type) {
   case "page"://check permissions and ask question for yes/no
   if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2)) {
    $sql="SELECT * FROM web_content WHERE wcid=$content_id"; 
    $page_data=sendquery($sql);
     if (!$page_data) {header("Location:$home_scr"."?status=9");}
    $yes=$_POST['Yes'];
    $no=$_POST['No'];
    $pid=$_POST['pid']; 
    if ($yes=="Yes") { //If yes button has been pressed..
     $sql="DELETE FROM web_content WHERE wcid=$pid LIMIT 1";
     $delete_result=sendquery($sql,"");
     header("Location:$home_scr"."?status=8");
     } elseif ($no=="No") { //If No button has been pressed..
        header("Location:$home_scr"."?action=display&type=page&id=".$pid);
      } else {
    $form="<form action='' method='post'> 
    <h2>Page Delete</h2><center><p>You are about to delete the page: <b>`<i>".$page_data['wtitle']."</i>`</b> with alias/link: `<b><i>". $page_data['alias']."</i></b>`</p>
    <p>Are you sure?</p>
    <input type='hidden' name='pid' value=$content_id>
    <input type='submit' name='Yes' value='Yes'><input type='submit' name='No' value='No'></center>
    </form>"; 
    $t_content.=$form; } //end check yes or no 
    }//endif perms
   break;//break statement for delete-page
  }
  break;//break for delete function in general
  case "add": //defines action when we need to add page, product_categories, users or other
  switch ($content_type) {
   case "page":
   if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2))  {
     $submit_page=$_POST['Submit'];
     $page_data=$_POST['body_text'];
     $window_title=$_POST['wtitle']; 
     $alias=$_POST['alias'];
     if ($submit_page=="Submit") { 
      $sql="INSERT INTO web_content (wcid, content, alias, wtitle) values ('DEFAULT', '$page_data', '$alias', '$window_title')";
      $result=mysql_query($sql) or die (mysql_error());
         $pid=mysql_insert_id();
         header("Location:$home_scr"."?action=display&type=page&id=".$pid);
       } else {
     //$form=var_dump($_POST);
     $form.="
     <script type='text/javascript' src='http://js.nicedit.com/nicEdit-latest.js'></script> 
     <script type='text/javascript'>
      //<![CDATA[
      bkLib.onDomLoaded(function() {
       new nicEditor({fullPanel : true}).panelInstance('text_editor');
                                   });
      //]]>
  </script>
  <form action='' method='post'>
     <em><b>Window title</b></em></br><input name='wtitle' type='text' style='width:100%' id='wtitle' required='required'></br>
     <em><b>Page Content</b></em></br><textarea name='body_text' cols='84' rows='10' id='text_editor' required='required'>Body Text</textarea></br>
     <em><b>Alias/Link</b></em></br><input name='alias' type='text' required='required'>
     <input type='submit' name='Submit' value='Submit'>
     </form>";
     $t_content=$form; }
     } else {header("Location:index.php?status=6");}
   break;
    } //end case for content type
  break;
  // diplay page decision making 
  case "display": 
   switch ($content_type) {
    case "page":
     $sql="SELECT * FROM web_content WHERE wcid=$content_id"; 
     $page_data=sendquery($sql);
      if (!$page_data) { //push the error message using a session 
     $_SESSION['t_content']="<h1>Show all pages right now.. Really? Why..?</h1>";
      header ("Location:$home_scr"."?status=3");
      } else {
       if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2)) {
         $t_content.="<a href='index.php?action=edit&type=page&id=$content_id' class='button-link'> <b>Edit Page</b> </a> &nbsp"; 
          $t_content.="<a href='index.php?action=delete&type=page&id=$content_id' class='button-link'> <b>Delete Page</b> </a>
         </br>"; 
         } //endif for enable edit and delete mode link 
       $t_content.="<h2>".$page_data['wtitle']."</h2>".$page_data['content'];
        } //endif for page data
    break;
    case "category":
    // the category action type should display the category data and the related products
    $sql="SELECT * FROM product_categories WHERE cat_id=$content_id"; 
    $page_data=sendquery($sql);//send query to database
    //strip the row fetched if it exists
     if (!$page_data) {
      $_SESSION['t_content']="<h1>Showing all categories right now is kind of an issue..</h1>";
      header ("Location:$home_scr"."?status=3");} 
    else {
     $catid=$page_data['cat_id'];
     $catname=$page_data['cat_name'];
     $catspecs=$page_data['cat_specs'];
     $cattblname=$page_data['cat_table_name'];
     $catimg=$page_data['cat_img'];
    //at this stage a standard html formatting is employed. 
    //later on this can be included in a theme file
    $html="<h2>Displaying Category: $catname</h2>";
    $html.="<br><i>Category Details:</i> ".$catspecs."<br>"; 
    //image link can be deployed later on 
    // display the products of this category 
    $html.="<h3>Products that belong to this category: </h3>"; 
    //query db; we already have what we need; note the backtrick ` character
    $sql="SELECT * FROM `$cattblname`";
    $page_data=sendquery($sql,1);//we need the result id 
       if (!mysql_num_rows($page_data)) {$html.="<center><h4>No Products Yet!</h4></center>";} 
       else {
         //prepare for loop 
         $count=mysql_num_rows($page_data);// count how many results; only ROWS
         $html.=$count." product(s) found:</br>";
         $html.="<table border='1'><tr><th>Name</th><th>Description</th><th>Price</th><th>Availability</th></tr>"; //design a table to display products
          for ($i=0;$i<$count;$i++) {
          //strip result to get fields of interest
             $product_id=mysql_result($page_data,$i,0);
             $product_name=mysql_result($page_data,$i,2);
             $product_desc=mysql_result($page_data,$i,3); 
             $product_price=mysql_result($page_data,$i,4);
             $product_availability=mysql_result($page_data,$i,5);
             $html.="<tr><td>$product_name</td><td>$product_desc</td><td>$product_price</td>";
               if ($product_availability>0){
                 $html.="<td>".$product_availability." in stock</td>"; 
                 $html.="<td><a href='?action=buy&type=product&id=$product_id'>BUY THIS</a></td>";
                 } else {$html.="<td>Not in Stock</td>";}
             $html.="</tr>";//end the table row
           }//end for loop
           $html.="</table>";
       }//endif for products 
     }//endif for category
      $t_content.=$html;
    break;
    case "product":
    break; 
   }
  
 }//end switch

} //end function  

?>
