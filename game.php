<?php
require 'lib/steampunked.inc.php';
require 'lib/site.inc.php';
$view = new Steampunked\SteampunkedView($Steampunked, $site);
/**
 * Created by PhpStorm.
 * User: Joshua Christ
 * Date: 2/18/2016
 * Time: 2:38 AM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    echo $view->head();
    ?>
</head>

<body>
<p>
    <img src="./images/title.png" width="600" height="104" alt="Title"><br>
</p>

<?php   //generate the game html
    echo $view->getHtml();
?>

</body>