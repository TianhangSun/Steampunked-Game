<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 10:09 PM
 */

namespace Steampunked;


class DeleteView extends  View
{
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->setTitle("Delete User");
        $this->addLink("users.php", "Users");
        $this->addLink("post/logout.php", "Logout");
    }
    public function present()
    {
        $user = new Users($this->site);
        $html="";
        if(isset($_GET['id'])) {
            $id = strip_tags($_GET['id']);
          //  $user = new Users($this->site);
            $users = $user->get($id);
            if ($users !== null) {
                $name = $users->getName();
                $deleteid = $users->getId();
                $html.= <<<HTML
<form method="post" action="post/delete-user.php">
	<fieldset>
		<legend>Delete?</legend>
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to delete this user who's name is <b>$name</b> and has a id of <b>$deleteid</b>
        </p>

		<p>Speak now or forever hold your peace.</p>
           <input type="hidden" name="id" value="$id">
		<p><input type="submit" name="Yes" value="Yes"> <input type="submit" name="No" value="No"></p>

	</fieldset>
</form>
HTML;
            }
            else
            {
                {
                    $html.= <<<HTML
<div id="alert" class="alerts">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message">ERROR! ID DOESN'T EXIST!</p>
</div>
HTML;


                }

            }
        }
        else
        {
                $html.= <<<HTML
<div id="alert" class="alerts">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message">ERROR! ID DOESN'T EXIST!</p>
</div>
HTML;


        }
        return $html;
    }

}