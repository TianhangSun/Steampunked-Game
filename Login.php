<?php $open = true;
require 'lib/steampunked.inc.php';
$login = new Steampunked\LoginView($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="lib/css/main-css.css" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Steampunked Login</title>
</head>

<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"><br>
    <img src="./images/steamsplash2.png" width="415" height="350" alt="Steampunked ScreenShot"></p>
<?php echo $login->errorMessage();?>
<form  method="post" action="post/login.php">
<fieldset>
    <legend>Login</legend>
    <div class="input">
    <p>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" placeholder="Email">
    </p>
    <p>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" placeholder="Password">
    </p>
    <p>
        <input id="login" type="submit" value="Log in">
        <a id="logout" href="index.php">Cancel</a>
    </p>
</div>
</fieldset>
</form>
</body>
</html>