<?php 
$html_head="<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html;charset=UTF-8' />
    <title>Plasteline | Install | Part 3</title>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script type='text/javascript'>function checkPasswordMatch() {
    var password = \$('#admin_pass').val();
    var confirmPassword = \$('#admin_pass_check').val();

    if (password != confirmPassword)
        \$('#divCheckPasswordMatch').html('Passwords do not match!');
    else
        \$('#divCheckPasswordMatch').html('Passwords match.');}
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
      <form method='post' action=''><br />
        <table width='583' border='0' height='231'>
          <tbody>
            <tr>
              <td align='right'>Administrator Username:</td>
              <td> <input type='text' name='admin_usrername' value='admin' placeholder='username'
                  required='required' size='20' maxlength='20' /></td>
            </tr>
            <tr>
              <td align='right'>Administrator Password:  </td>
              <td><input type='password' name='admin_password1' placeholder='password '
                  required='required' size='20' maxlength='20' id='admin_pass'/><br />
              </td>
            </tr>
            <tr>
              <td align='right'>Administrator Password (Again): </td>
              <td> <input type='password' name='admin_password2' placeholder='password again'
                  required='required' size='20' maxlength='20' id='admin_pass_check' onkeyup='checkPasswordMatch();'/>
                  <div class='registrationFormAlert' id='divCheckPasswordMatch'></div> </td>
            </tr>
            <tr>
              <td align='right'>Administrator Name: </td>
              <td> <input type='text' name='admin_fname' placeholder='Your First Name'
                  size='25' maxlength='25' /></td>
            </tr>
            <tr>
              <td align='right'>Administrator Surname: </td>
              <td><input type='text' name='admin_surname' placeholder='Your Surname'
                  required='required' size='25' maxlength='25' /><br />
              </td>
            </tr>
            <tr>
              <td align='right'>Administrator Email:<br />
              </td>
              <td><input type='text' name='admin_email' placeholder='Admin Email'
                  required='required' size='20' maxlength='20' /><br />
              </td>
            </tr>
          </tbody>
        </table>
        <input type='submit' name='Done' value='Done'/><br />
      </form>
     

      <br />
      <br />
    </div>";
$html_closure="<p></p>
  </body>
</html>";

echo $html_head.$html_body.$html_form.$html_closure; 

?>
