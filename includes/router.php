<?php
/**
 * Date: 03-Feb-15
 * Time: 5:03 PM
 */
//include_once "mysql.php";
class Router
{
    public static function getModule()
    {
        $page_action=@$_GET['action'];
        $content_type=@$_GET['type'];
        $content_id=@$_GET['id'];

        $query = "SELECT function from `routes` WHERE action='$page_action'";
        if (!empty($content_type))
        {
            $query .=  "AND type = '$content_type'";
        }
        echo $query;
        $result = sendquery($query, 1);
        $function = $result[0]['function'];
        $folder = "modules/".$function."/".$function.".php";
        echo $folder;
        if (is_readable($folder) and !is_uploaded_file($folder)) {
            include $folder;
           // call_user_func($function, $content_id);
        }
    }
}

?>