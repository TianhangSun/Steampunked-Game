<?php
$open = false;		// Can be accessed when not logged in
require '../lib/steampunked.inc.php';
unset($_SESSION['user']);
$root = $site->getRoot();
header("location: $root/");
exit;
