<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 3/21/2016
 * Time: 4:46 PM
 */

namespace Steampunked;


class LoginView extends View
{
    public function __construct($get)
    {
        $this->get = $get;
        foreach($get as $value)
        {
            $value = strip_tags($value);


        }
        if(isset($get['e']))
        {
            $this->error = true;
        }
    }
    public function errorMessage()
    {
        if($this->error == true) {
            $html = "<p><b>Error! Invalid Password or User Name</b></p>";
            return $html;
        }
    }
    private $error = false;

}