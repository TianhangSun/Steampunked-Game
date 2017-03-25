<?php
require 'lib/steampunked.inc.php';
$view = new Steampunked\UsersView($site);
if(!$view->protect($site, $user)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head();?>
    <script src="users-form.js"></script>

</head>
<?php echo $view->header();?>
<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"></p>
<?php echo $view->present();?>


</body>
</html>