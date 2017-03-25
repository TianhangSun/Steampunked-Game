<?php
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/2/17
 * Time: 下午11:14
 */
require __DIR__ . "/../vendor/autoload.php";

$localize = require 'localize.inc.php';
$site = new Steampunked\Site();

session_start();

define("STEAMPUNKED_SESSION", 'Steampunked');

// If there is a session, use that. Otherwise, create one
if(!isset($_SESSION[STEAMPUNKED_SESSION])) {
    $_SESSION[STEAMPUNKED_SESSION] = new Steampunked\Steampunked();
}

$Steampunked = $_SESSION[STEAMPUNKED_SESSION];

if(isset($_GET['seed'])) {
    $_SESSION[STEAMPUNKED_SESSION] = new Steampunked\Steampunked(strip_tags($_GET['seed']));
}

$Steampunked = $_SESSION[STEAMPUNKED_SESSION];


if(is_callable($localize)) {
    $localize($site);
}
//session_start();
$user = null;
if(isset($_SESSION[Steampunked\User::SESSION_NAME])) {
    $user = $_SESSION[Steampunked\User::SESSION_NAME];
}
