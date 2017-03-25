<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . '/lib/steampunked.inc.php';
require './lib/site.inc.php';
$controller = new \Steampunked\SteampunkedController($Steampunked, $_POST, $site);
if($controller->isReset()) {
    $id = $_SESSION[STEAMPUNKED_SESSION]->getId();
    $controller->clearDB($site,$id);
    unset($_SESSION[STEAMPUNKED_SESSION]);
}

echo "<pre>";
print_r($_POST);
echo "</pre>";

header("location: ".$controller->getPage());