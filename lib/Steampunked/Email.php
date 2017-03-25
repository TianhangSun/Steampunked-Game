<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 12:55 PM
 */

namespace Steampunked;



class Email
{
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}