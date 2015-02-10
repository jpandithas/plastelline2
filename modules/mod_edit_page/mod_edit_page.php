<?php
/**
 * Date: 27-Jan-15
 * Time: 4:45 PM
 */

global $t_content;
if ((isset($_SESSION['u_class'])) and ($_SESSION['u_class']<2))  {
    $sql="SELECT * FROM web_content WHERE wcid=$content_id" or die(mysql_error());
    $page_data=@sendquery($sql, 1);
    var_dump($page_data);
    $edit_wcid=$page_data[0][0];
    $edit_content=$page_data[0][1];
    $edit_alias=$page_data[0][2];
    $edit_wtitle=$page_data[0][3];
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
        $t_content=$form;
    }
}
else {header("Location:index.php?status=6");}

?>