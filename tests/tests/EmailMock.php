<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/15/2016
 * Time: 10:19 PM
 */
class EmailMock extends Steampunked\Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}