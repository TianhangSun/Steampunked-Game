<?php
$open= true;
require '../lib/steampunked.inc.php';

$controller = new Steampunked\LostPasswordController($site, $_POST);
header("location: " . $controller->getRedirect());
