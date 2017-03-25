<?php
$open = true;
require 'lib/steampunked.inc.php';
$view = new Steampunked\UserView($site, $_GET);
if(isset($_GET['id'])) {
 $id = strip_tags($_GET['id']);
 if (!$view->getCurrentUserId($site, $id, $user)) {
  header("location: " . $view->getProtectRedirect());
  exit;
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php echo $view->head();?>
 <script src="user-form.js"></script>
</head>
<?php echo $view->header();?>
<body>
<p><img src="./images/title.png" width="600" height="104" alt="Title"></p>

<?php echo $view->present();?>


</body>
</html>