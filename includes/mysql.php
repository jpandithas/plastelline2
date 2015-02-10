<?php
//include the db settings 
include ("settings/settings.php");

//database functions here

//find if the db exists helper function
function db_exists() {
 global $host, $db_user,$db_pass, $database;
    try
    {
        $pdo = new PDO("mysql:host=localhost;dbname=$database", $db_user, $db_pass);
    }
    catch (PDOException $e)
    {
        $message = $e->getMessage();
        error_screen($message);
    }
}
//error screen displaying a message to the user
function error_screen($h_error_message) {
$err_html="<h2>This is most unfortunate..</h2><hr>";
$err_html.="<h3>Eshop Cannot Function.</h3>";
$err_html.="<b>Something is wrong with your database!</b>";
$err_html.="<br><b>You need to take care of the following:</b> ".$h_error_message;
$err_html.="<hr><i>Hint: You need a database setup and a user assigned, that uses it</i>"; 
print($err_html);
die();
}

//this function finds a user from the database; 
function db_get_user($g_username,$g_password) {
 global $username, $password, $host, $db_user,$db_pass,$database;
    $pdo = new PDO("mysql:host=localhost;dbname=$database", $db_user, $db_pass);
    $q = $pdo->prepare("SELECT uid FROM $database.users WHERE username= :username AND password= :password");
    $q->bindParam(':username', $g_username);
    $q->bindParam(':password', $g_password);
    $q->execute();
    $found = $q->fetchColumn(0);
 return $found; 
}
//grab the user and write to $_SESSION 
function grab_user($g_username) {
 global $username, $password, $host, $db_user,$db_pass,$database, $u_name, $u_surname, $u_class;
 $connect=@mysql_connect($host,$db_user,$db_pass);
 @mysql_select_db($database,$connect);
 $sql="SELECT name,surname,userclass FROM $database.users WHERE username='$g_username' ";
 $db_result=@mysql_query($sql,$connect) or die (mysql_error());
 //fetch the results from the database and copy them to session
 $usrdata=@mysql_fetch_array($db_result);
 $u_name=$usrdata['name']; 
 $_SESSION['u_name']=$u_name;
 $u_surname=$usrdata['surname']; 
 $_SESSION['u_surname']=$u_surname;
 $u_class=$usrdata['userclass']; 
 $_SESSION['u_class']=$u_class; 
}//end function grab_user

//Function that sends a query to the database and returns the results
//option when other than null returns the result of the query
function sendquery ($sqlquery,$option) {
 global $host, $db_user,$db_pass,$database;
    $pdo = new PDO("mysql:host=localhost;dbname=$database", $db_user, $db_pass);
    $stmt = $pdo->prepare($sqlquery);
    $done = $stmt->execute();
   $query_data = $stmt->fetchAll();
 if ($option=="")  { return $done; } else {return $query_data;}
}

?>
