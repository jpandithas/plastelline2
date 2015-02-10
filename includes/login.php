<?php 
//login script 
 function login() {
     if (!empty($_POST))
     {
         $username = $_POST['username'];
         $password = $_POST['password'];
         $button = $_POST['submit'];
     }
     if (isset($button)) { 
        if ((!$username) or (!$password)) {
            header ("Location:index.php?status=4");
        } else {
           $user_found=db_get_user($username,$password);
           if ($user_found>=1) {
           //grab user data->start the session->redirect
             grab_user($username); 
             header ("Location:index.php?status=5");
             }//endif ->user found 
           }//end else  
                         } //end if for isset button
   $login_code="<br><div id='loginhead'><b>USER LOGIN</b></div>";
   $login_code.="<table id='logintable' >";
   $login_code.="<form action='' method='POST'>";
   $login_code.="<tr><td>USERNAME</td></tr>";
   $login_code.="<tr><td><input type='text' name='username' size=15></td></tr>";
   $login_code.="<tr><td>PASSWORD</td></tr>";
   $login_code.="<tr><td><input type='password' name='password'size=15></td></tr>";
   $login_code.="<tr><td><input type='submit' name='submit' value='Login' size=15></td></tr>";
   $login_code.="</form>";
   $login_code.="</table>";
   print($login_code);
 }//end login function

?>
