<?php
$open = true;		// Can be accessed when not logged in
require '../lib/steampunked.inc.php';
$controller = new Steampunked\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
