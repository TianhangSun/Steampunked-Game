<?php
require '../lib/steampunked.inc.php';
$controller = new Steampunked\DeleteUserController($site, $_POST);
header("location: " . $controller->getRedirect());

