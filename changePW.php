<?php
$open = true;
require 'lib/steampunked.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="lib/css/main-css.css" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Steampunked Change Password</title>
</head>

<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"><br>
    <img src="./images/steamsplash2.png" width="415" height="350" alt="Steampunked ScreenShot"></p>

<form method="post" action="post/password-recovery.php">
    <fieldset>
        <legend>Change Password</legend>
        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="" placeholder="Email">
        </p>


        <input type="submit" name="add" value="OK"> <input type="submit" name="cancel" value="Cancel">
        </p>

    </fieldset>
</form>

</body>
</html>