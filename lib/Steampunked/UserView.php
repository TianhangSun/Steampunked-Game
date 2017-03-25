<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 5:59 PM
 */

namespace Steampunked;


class UserView extends View
{
    public function __construct(Site $site, array $get)
    {
        $this->site = $site;


        if (isset($_GET['id'])) {
            $this->id = strip_tags($_GET['id']);
            if(isset($_SESSION['user'])) {
               $user= $_SESSION['user']->getRole();
            if($user==='A')
            {
                $this->addLink("users.php", "Users");

            }
            }
            if($this->id <= 0)
            {
                $this->setTitle("New User");

            }
            else
            {
                $this->setTitle("Edit User");
            }

        }
        $this->addLink("post/logout.php", "Logout");
    }
    public function present()
    {
        if($this->id <=0)
        {
            $html=<<<HTML
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message"></p>
</div>
<form method="post" action="post/new-user.php" id="new" >
    <fieldset>
        <legend>New User</legend>
        <p>Note: an e-mail with the link to set the password<br>will be sent to the provided e-mail address</p>
        <div class="input"><p>
                <label for="name">Name: </label>
                <input type="text" name="name" id="name">
            </p>
            <p>
                <label for="email">E-mail Address: </label>
                <input type="email" name="email" id="email" required>
            </p>

        </div>
        <p><input type="submit" value="OK" name="add" id = "login" onclick="user(event);">
        <input type="submit" id="cancel" value="Cancel" onclick="cancel(event);" formnovalidate>
        <input type="hidden" value="" name="id" id="id">
        <input type="hidden" value="G" id="role" name="role"> </p>
    </fieldset>
</form>
HTML;

        }
        else
        {
            $users = new Users($this->site);
            $user = $users->get($this->id);
            $userName = $user->getName();
            $userId =$user->getId();
            $userEmail = $user->getEmail();
            $userRole = $user->getRole();
            $html =<<<HTML
            <div class="alert" style="display:none;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message"></p>
</div>
            <form method="post" action="post/new-user.php"  id="edit">
    <fieldset>
        <legend>Edit User</legend>
        <p>Note: an e-mail with the link to set the password<br>will be sent to the provided e-mail address</p>
        <div class="input">
        <p>
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" value="$userName">
            </p>
            <p>
                <label for="email">E-mail Address: </label>
                <input type="text" name="email" id="email" value="$userEmail" required>
            </p>
            <p>
HTML;
            $userTest =$_SESSION[User::SESSION_NAME];
            $currentRole = $userTest->getRole();
            if($currentRole == 'G')
            {
          //  echo $userTest->getId()

               $html.=<<<HTML

        <input type="hidden" value="$userRole" id="role" name="role">
HTML;
}           if($currentRole=='A') {
            $x = "Admin";
            $y = "Gamer";

            if ($userRole == 'G') {
                $html .= <<<HTML
<label for="role">Role: </label>
        <select id="role" name="role">
        <option value ="$userRole" selected>$y</option>
        <option value="A">Admin</option>
        </select>
HTML;
            }
            if ($userRole == 'A') {
                $html .= <<<HTML
        <label for="role">Role: </label>
        <select id="role" name="role">
        <option value ="$userRole" selected>$x</option>
        <option value="G">Gamer</option>
        </select>
HTML;
            }
        }

            $html.=<<<HTML
            </p>

        </div>
        <p><input type="submit" value="OK" id="add" name="add" onsubmit="return user(event);">
        <input type="submit" value="Cancel" name="cancel" id="cancel">
      <input type="hidden" value="$userId" name="id" id="id"> </p>
    </fieldset>
</form>

HTML;

        }
        return $html;
    }
    private $id;

}