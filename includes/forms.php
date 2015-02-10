<?php


/**
 * Class Webform
 * Usage: This Class is instantiated with form id, form method, form name
 * Example $form  = new Webform("scriptname.php", "GET", "myform")
 *
 */
class Webform
{
    protected $formdata;


    /**
     * @param $action
     * @param $method
     * @param $name
     */
    public function __construct($action, $method, $name)
    {
        $this->formdata = "<form name = " . $name ." action = ". $action. " method = ". $method." > ";
    }

    /**
     * @param $text
     * @param $varname
     */
    public function insert_textbox($text, $varname)
    {
        $this->formdata .= $text.": <input type='text' name=".$varname."><br>";
    }

    /**
     * @param $text
     * @param $varname
     */
    public function insert_passwordbox($text, $varname)
    {
        $this->formdata .= $text.": <input type='password' name=".$varname."><br>";
    }

    /**
     * @param $text
     */
    public function insert_submit($text)
    {
        $this->formdata .= "<br><input type='submit' value=".$text.">";
    }

    /**
     * @param $name
     * @param array $options
     */
    public function insert_option($name, Array $options)
    {
        $this->formdata .= "<select name = '".$name."'>";
        foreach ($options as $tag_options)
        {
            $this->formdata .= "<option value = '".$tag_options."'>".$tag_options."</option>";
        }
        $this->formdata .= "</select>";

    }

    /**
     * @param $text
     */
    public function add_text($text)
    {
        $this->formdata .= $text;
    }

    /**
     * @return string
     */
    public function getForm()
    {
        return $this->formdata."</form>";
    }

}

?>