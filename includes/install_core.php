<?php 

//step one of the install process: html is produced and the control goes out in $_POST['step']
//via a hidden html form input element
function inst_step_1() {
global $post_status;
//initialize step status for the form  
$step="step2";
$html= "<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html;charset=UTF-8' />
    <link href='includes/form_style.css' rel='stylesheet' type='text/css'>
    <title>Plasteline | Install Welcome!</title>
  </head>
  <body>
    <h1 align='center'><font color='#000066'>P</font><font color='#003333'>L</font><font
        color='#330000'>A</font><font color='#cc9933'>S</font><font color='#333333'>T</font><font
        color='#330033'>E</font><font color='#3333ff'>L</font><font color='#cc0000'>I</font><font
        color='#003333'>N</font>E | Install </h1>
    <h2 align='center'><font color='#000066'>Welcome!</font><br />
      <div align='center'><progress value='1' max='4' form='install_meter'>Step
          1 of 5</progress> </div>
    </h2>
    <center><p>Thank you for using Plasteline CMS. The following steps must be taken in
      order to setup the Functionality of the machine:<br />
    </p></center>
  
       <p align='center'>1. Make sure that you have Apache, PHP and MySQL installed on your
        system.</br>
       2. Make sure that you have access to the MySQL server (username, password
        and location - usually this is 'localhost')</br>
       3.Follow the instructions.</p>
       <form method='post' action=''>";
$step="step2";
$html.="<p align='center'>Your web server version is : ".apache_get_version()."<font color='green' size='5'>&nbsp;&#10004;</font> </p>";
$html.="<p align='center'>Your MySQL version is : ".mysql_get_client_info()."<font color='green' size='5'>&nbsp;&#10004;</font> </p>";
$html.="<p align='center'>Your PHP version is : ".phpversion()."<font color='green' size='5'>&nbsp;&#10004;</font> </p>";

//check if the settings folder is there! 
if (is_dir('settings')) {$html.="<p align='center'>'Settings' Folder Exists<font color='green' size='5'>&nbsp;&#10004;</font> </p>";} 
else {$html.="<p align='center'>'Settings' Folder Does not Exist.<font color='red' size='5'>&nbsp;&#10008;</font> </br><em>Please Make sure that you have installed Plastelline correctly!</em></p>"; $step="step1";}
//check if the settings.php file is there! 
if (is_writable('settings/settings.php')) {$html.="<p align='center'>'Settings' File Exists and Writable!<font color='green' size='5'>&nbsp;&#10004;</font> </p>";} 
else {
$html.="<p align='center'>'Settings' File Does not Exist or not Readable.<font color='red' size='5'>&nbsp;&#10008;</font> </br>
<em>Please make sure that the web server car access the file! </br> Hint: find who the file owner is and chown it to apache:apache..</em> </p>"; $step="step1";}
//check if the current settings file exists! if so, it appears that the engine has been installed!  
if (is_file('settings/active_settings.php')) {$html.="<p align='center'>It seems that Plasteline is installed..<font color='red' size='5'>&nbsp;&#10008;</font> </br> <em>Check your settings folder..</em></p>"; $step="step1";} 
else {$html.="<p align='center'>Current Settings Can be Created!<font color='green' size='5'>&nbsp;&#10004;</font> </br></p>";}


//submit form
$html_form.="
       <input type='hidden' name='step' value='$step'>
       <center><input type='submit' name='Start' value='Start'></center>
       </form >   
  </body>
</html> "; 

echo $html.$html_form;


}//end function


// step 2: a crucial part of the installation procedure, since database and the site settings file is created
// a form is displayed where the user data is validated via jquery and setup proceeds upon correct data submission
// the active_settings file is written using settings.php as a template for that; if for any reason the file is compromised, setup
// cannot continue.
// The fucntion calls install_schema fucntion to setup database 

function inst_step_2() {
global $post_status; 

$install_errors=$_SESSION['errors'];
//strip $_POST from contents
$button=$_POST['step2_button'];
$db_location=$_POST['mysql_location'];
$db_name=$_POST['db_name'];
$db_username=$_POST['db_username'];
$db_password=$_POST['db_password'];
// setup the header of the html install form
// the header contains the jQuery functions to check the form and databse username/password availability
$html_head="<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html;charset=UTF-8' />
    <title>Plastelline | Install: Step 2</title>
      <link rel='stylesheet' href='http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css'>
      <link href='includes/form_style.css' rel='stylesheet' type='text/css'>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script src='http://code.jquery.com/ui/1.10.0/jquery-ui.js'></script>
    <script type='text/javascript'>
	\$(document).ready(function(){
	\$('#host').keyup(username_check);});
	\$(document).ready(function(){
	\$('#username').keyup(username_check);});
	\$(document).ready(function(){
	\$('#password').keyup(username_check);});
	
	
function username_check(){	
var host = \$('#host').val();
var db_user = \$('#username').val();
var db_pass = \$('#password').val();
if(db_user == '' || host== '' || db_pass==''){
\$('#msg1').css('color', 'blue');
\$('#msg1').html('<center><b><i>Fill in the Host, Username and Password Fields..</b></i></center>');
}else{
jQuery.ajax({
   type: 'POST',
   url: 'check_user.php',
   data: 'db_user='+db_user+'&host='+host+'&db_pass='+db_pass,
   cache: false,
   success: function(response){
if(response == 1){
	\$('#username').css('border', '3px #090 solid');	
	\$('#msg1').css('color', 'green');
	\$('#msg1').html('<center><b>User Exists. Setup Can Continue.</b></center>');
	}else{
	\$('#username').css('border', '3px #F00 solid');
	\$('#msg1').css('color', 'red');
	\$('#msg1').html('<center><i>User Does Not Exist</i></center>');}
                              }
});
}

}
</script>

  </head>
  <body>
    <h1 align='center'> <font color='#000066'>P</font><font color='#003333'>L</font><font
        color='#330000'>A</font><font color='#cc9933'>S</font><font color='#333333'>T</font><font
        color='#330033'>E</font><font color='#3333ff'>L</font><font color='#cc0000'>I</font><font
        color='#003333'>N</font>E | Install <br />
    </h1>
    <h2 align='center' id='Part '>Part 2 | Setup Database! </h2>
    <div align='center'><progress value='2' max='4' form='install_meter'>Step 1
        of 5</progress> <br />
    </div>";
//check what happened with the install button and modify html accordingly
if (($button=="Set me up!") and (($db_username=="") or ($db_password=="") or ($db_name==""))) {
 $html.="<p align='center'>Your submission contains empty fields</p> <form action='' method='post'><input type='hidden' name='step' value='step2'> <p align='center'><input type='submit' name='step2_button' value='Retry'/><br /> </p>
    </form>"; 
 } else if ($button=="Set me up!") { //if form data is ok, carry on with installation
   $settings_file_status=settings_file($db_location,$db_name,$db_username,$db_password);
   //check if the settings file has been created no meaning to proceed setup if not! 
  if ($settings_file_status==1) { $html_form="<form action='' method='post'><p align='center'><font color='red'>&#10008; The file 'active_settings.php' could not  be created properly!</font></br><em>Check that the file 'settings/settings.php' exists and has data in it.</em> </p><input type='hidden' name='step' value='step2'>
      <p align='center'><input type='submit' name='step2_button' value='Retry'/><br />
      </p>
    </form>"; } else { //else, carry on to install the database schema
   $db_install=install_schema($db_location,$db_name,$db_username,$db_password);
   if ($db_install['status']==0)  { $db_install['message'].= "Settings file 'active_settings.php' has been created!<font color='green' size='5'>&nbsp;&#10004;</font></br>";
     $html_form=" <form action='' method='post'> <input type='hidden' name='step' value='step3'>
      <p align='center'>".$db_install['message']."<input type='submit' name='step2_button' value='Go to Step 3!'/><br />
      </p>
    </form>"; } else { $html_form="<form action='' method='post'><p align='center'>Database Errors Found! ".$db_install['message']."</p><input type='hidden' name='step' value='step2'>
      <p align='center'><input type='submit' name='step2_button' value='Retry'/><br />
      </p>
    </form>"; }
        } //end the else clasue for the settings file creation
   } //endif for checking the what the form button value is
   else { //no button has been pressed show initial form
    $html.="<p align='center'>We are Good to Go! Please fill in the following Details.
      Remember to issue correct information. <br /> </p> ";
  //render the original form
	$html_form=" 
	<center><form action='' method='post'>
	<fieldset style='width:60%;'><legend>Please Fill in the Form</legend>
	<div class='msg1' id='msg1'></div>
     <table>
     <tr><td>Database Location: </td><td><input type='text' name='mysql_location' id='host' onKeyup='username_check();'
          value='localhost' required='required' size='15' /></td></tr>
      <tr><td>Database Name: </td><td><input type='text' name='db_name'
           placeholder='Database Name' required='required' size='15' maxlength='15'/></td></tr>
      <tr><td>Database Username: </td><td><input type='text' name='db_username' id='username' onKeyup='username_check();'
           placeholder='Database Username' required='required' size='15' maxlength='15'/></td></tr>
      <tr><td>Database Password: </td><td><input type='text' name='db_password' id='password' onKeyup='username_check();'
         required='required' size='15' maxlength='15' placeholder='Database password' /></td></tr>
          <input type='hidden' name='step' value='step2'>
      </table></fieldset>
      <tr><td colspan='2'><input type='submit' name='step2_button' value='Set me up!'/></td></tr>
      
    </form></center>"; }
    //print closure of the html document
$html_closure= "<p align='center'><br />  </p>  </body> </html>";
echo $html_head.$html_body.$html_form.$html_closure; 
}

//function to open and read, then, write the active_settings file
function settings_file ($db_host,$db_name,$db_user,$db_pass) {

$file_d=file('settings/settings.php');
$found=0;

foreach ($file_d as $key => &$value) {
if (stristr($value,'$host')) { $value="\$host=\"$db_host\"; \n"; $found=1; break;} 
}

foreach ($file_d as $key => &$value) {
if (stristr($value,'$database')) { $value="\$database=\"$db_name\"; \n";$found=1; break;} 
}

foreach ($file_d as $key => &$value) {
if (stristr($value,'$db_user')) { $value="\$db_user=\"$db_user\"; \n"; $found=1; break;} 
}

foreach ($file_d as $key => &$value) {
if (stristr($value,'$db_pass')) { $value="\$db_pass=\"$db_pass\"; \n";$found=1; break;} 
}
//if all info found and edited on settings file, write it. else, do not and return error -> '1'
if ($found==0) {return 1;} else {
	file_put_contents('settings/active_settings.php',$file_d); //write the file to the server
	chmod ('settings/active_settings.php',0444); // set file perms to read only ->'0444'
	return 0;} //endif 

}//end function

//install batabase schema

function install_schema ($db_location,$db_name,$db_username,$db_password){

$connect=mysql_connect($db_location,$db_username,$db_password); 
 if (!$connect) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; }

$sql="CREATE DATABASE $db_name";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } 
  else { $error_state['status']=0; $error_state['message'].="Database: '$db_name' Created!<font color='green' size='5'>&nbsp;&#10004;</font></br>";}

mysql_select_db($db_name,$connect);

$sql="CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `userclass` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].=" Installed Users<font color='green' size='5'>&nbsp;&#10004;</font></br>";}


$sql="CREATE TABLE `web_content` (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `wtitle` varchar(150) NOT NULL,
  PRIMARY KEY (`wcid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Web Content Capability<font color='green' size='5'>&nbsp;&#10004;</font></br>";}


$sql="CREATE TABLE `settings` (
  `setid` int(11) NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(50) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `footer_msg` text,
  `currency` varchar(30) NOT NULL,
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Settings<font color='green' size='5'>&nbsp;&#10004;</font> </br>";}


$sql="CREATE TABLE `product_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(40) NOT NULL,
  `cat_specs` text,
  `cat_table_name` varchar(50) NOT NULL,
  `cat_img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Product Category Template<font color='green' size='5'>&nbsp;&#10004;</font> </br>";}

$sql="CREATE TABLE `prod_name` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_desc` text,
  `prod_price` float NOT NULL,
  `prod_avail` int(11) NOT NULL,
  `prod_img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Product Indexing Capability<font color='green' size='5'>&nbsp;&#10004;</font> </br>";}

$sql="CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Event Logging Capability<font color='green' size='5'>&nbsp;&#10004;</font></br>";}

$sql="CREATE TABLE `basket` (
  `basket_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` enum('ordered','processed','empty','complete') DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$result=mysql_query($sql,$connect); 
if (!$result) {$error_state['status']=1; $error_state['message']=mysql_error();return $error_state; } else {
  $error_state['status']=0; $error_state['message'].="Installed Product Basket Capability<font color='green' size='5'>&nbsp;&#10004;</font></br>";}

$error_state['message'].="Databse Setup Complete!<font color='green' size='5'>&nbsp;&#10004;</font></br>";

return $error_state;

}


// step 3 : get the final data from the user, like admin username and password 

function inst_step_3() {
//actually use the settings file
include('settings/active_settings.php');
//strip $_POST to get data including the form button
//the php form validation and data entry to dB happens BEFORE rendering the form 
//while the user sees the form, it is validated by jQuery Validate plugin
$admin_username=$_POST['admin_username'];
$admin_password=$_POST['admin_password2']; //it has been validated within the form!
$admin_fname=$_POST['admin_fname'];
$admin_lname=$_POST['admin_lname'];
$admin_email=$_POST['admin_email'];
$form3button=$_POST['Done'];
//var_dump($_POST);
// setup the main html environment variables. 
$html_head="<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html;charset=UTF-8' />
    <title>Plasteline | Install | Part 3</title>
    <link href='includes/form_style.css' rel='stylesheet' type='text/css'>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script type='text/javascript' src='http://jzaefferer.github.com/jquery-validation/jquery.validate.js'></script>
    <script type='text/javascript'>function checkPasswordMatch() {
    var password = \$('#admin_pass').val();
    var confirmPassword = \$('#admin_pass_check').val();

    if (password != confirmPassword) {
        \$('#divCheckPasswordMatch').css('color','red');
        \$('#divCheckPasswordMatch').html('Passwords do not match!');
     }else {
        \$('#divCheckPasswordMatch').css('color','green');
        \$('#divCheckPasswordMatch').html('Passwords match.');}}
   \$(document).ready(function () {
   \$('#txtConfirmPassword').keyup(checkPasswordMatch); });
        </script>
  </head>
  <body>
    <h1 align='center'> <font color='#000066'>P</font><font color='#003333'>L</font><font
        color='#330000'>A</font><font color='#cc9933'>S</font><font color='#333333'>T</font><font
        color='#330033'>E</font><font color='#3333ff'>L</font><font color='#cc0000'>I</font><font
        color='#003333'>N</font>E | Install <br />
    </h1>
    <h2 align='center' id='Part '>Part 3 | Administrator Account</h2>
    <div align='center'><progress value='3' max='4' form='install_meter'>Step 1
        of 5</progress> <br />
      <br />
    </div>";
    
$html_form="<div align='center'>Database Setup Has been Successful!<br />
      <br />
      Please fill in the details for the Administrator Account <br />
      <br />
      <script type='text/javascript'>
      \$(document).ready(function () { \$('#admin_form').validate(); });
      </script>
      
        <form method='post' action='' id='admin_form'>

            <fieldset> <legend>Fill in This form</legend>
            <table border='0'>
            <tr>
              <td align='right'><label for='admin_username'>Administrator Username:</label></td>
              <td> <input type='text' name='admin_username' value='admin' placeholder='username' class='required'
                   id='admin_username' size='20' maxlength='20' /></td></tr>
          
            <tr>
              <td align='right'><label for='admin_pass'>Administrator Password:</label></td>
              <td><input type='password' name='admin_password1' placeholder='password ' class='required'
                   size='20' maxlength='20' id='admin_pass'/></td>
              </tr>
            
            <tr>
              <td align='right'><label for='admin_pass_check'>Administrator Password (Again): </label></td>
               <td><input type='password' name='admin_password2' placeholder='password again' class='required'
                   size='20' maxlength='20' id='admin_pass_check' onkeyup='checkPasswordMatch();'/>
                  <div class='registrationFormAlert' id='divCheckPasswordMatch'></div> </td>
            </tr>
            <tr>
              <td align='right'><label for='admin_fname'>Administrator Name: </label></td>
              <td><input type='text' name='admin_fname' placeholder='Your First Name' id='admin_fname' class='required'
                  size='25' maxlength='25' /></td>
            </tr>
            <tr>
              <td align='right'><label for='admin_lname'>Administrator Surname: </label></td>
              <td><input type='text' name='admin_lname' placeholder='Your Surname' id='admin_lname' class='required'
                   size='25' maxlength='25' /></td>
              </tr>
            
              <tr>
              <td align='right'><label for='admin_email' >Administrator Email:</label></td>
              <td><input type='text' name='admin_email' placeholder='Admin Email' id='admin_email' class='required email'
                   size='20' maxlength='20' /></td>
              </tr>
             
        <tr> <input type='hidden' name='step' value='step3'>
        <td align='center' colspan='2'><input type='submit' name='Done' value='Done'/></td></tr>
        </table>
     </fieldset>
      </form> ";
$html_closure="<p></p>
  </body>
</html>";
// start checking the status of the form button and submit data to the cms
// if the button has been pressed 'thus, it has a value of Done' perform the actions.
// otherwise, remain in the form 
if ($form3button=="Done") {
    $connect=mysql_connect($host,$db_user,$db_pass) or die(mysql_error()); 
  if (!$connect) {$error_state="1";} else {$error_state="0";}

//if jQuery has validated the form, proceed into feeding the data into the engine
//for the moment, only the user with id '1' <superuser> will be inserted 
//build the query INSERT 
$home_scr1=dirname($_SERVER['PHP_SELF']);
 mysql_select_db($database,$connect) or die(mysql_error());
  $sql="INSERT INTO $database.users VALUES (1,'$admin_username','$admin_password','$admin_email','$admin_fname','$admin_lname','0')";
  $result=mysql_query($sql,$connect) or die(mysql_error());
  $html_form="<form action='$home_scr' method='post'> 
      <p align='center'>User Administrator: `$admin_username` has been created<font color='green' size='5'>&nbsp;&#10004;</font><br>
      Hosted on: $home_scr1</p></br> <p align='center'> The administrator account cannot be deleted.</p><p align='center'> You can now start using Plasteline. </p>
      <input type='hidden' name='step' value='done'>
      <p align='center'><input type='submit' name='form3button' value='Finish'/><br />
      </p>
    </form>"; 
  }
//the html output is rendered here; all action takes place prior to this step
echo $html_head.$html_body.$html_form.$html_closure; 

}



?>
