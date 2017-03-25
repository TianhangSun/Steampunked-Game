<?php

require '../lib/steampunked.inc.php';
$open = true;
$controller = new Steampunked\PasswordValidateController($site, $_POST);
header("location: " . $controller->getRedirect());
