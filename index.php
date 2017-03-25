<?php
$open = true;
require 'lib/site.inc.php';
require 'lib/steampunked.inc.php';
$game = new \Steampunked\Games($site);
$available = $game->available();
$view = new Steampunked\IndexView($site);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="lib/css/main-css.less" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Welcome to Steampunked</title>
</head>

<body>
<?php
    echo $view->getHTML($available);
?>

</body>