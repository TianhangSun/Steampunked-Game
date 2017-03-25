<?php
$open = true;		// Can be accessed when not logged in
require '../lib/steampunked.inc.php';
$controller = new Steampunked\UsersController($site, $_POST);
header("location: " . $controller->getRedirect());

