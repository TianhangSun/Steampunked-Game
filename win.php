<!DOCTYPE html>
<html lang="en">
<head>
    <link href="lib/css/main-css.less" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Win</title>
</head>

<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"><br>
    <img src="./images/steamsplash2.png" width="415" height="350" alt="Steampunked ScreenShot"></p>

<?php
    require 'lib/steampunked.inc.php';
    echo $Steampunked->getWinnerHTML();
?>

<form method="post" action="game-post.php">
    <p><input type="submit" value="Back to Welcome Page" name="back" id = "back"></p>
</form>
</body>