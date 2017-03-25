<?php
$open = true;
require 'lib/steampunked.inc.php';
$view = new Steampunked\PasswordValidateView($site, $_GET);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $view->head(); ?>
    <script src="validator-form.js"></script>

</head>


<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"><br>
    <img src="./images/steamsplash2.png" width="415" height="350" alt="Steampunked ScreenShot"></p>
<?php echo $view->present();?>
</body>
</html>