<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 8:48 PM
 */

namespace Steampunked;


class UsersView extends View
{
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->setTitle("Users View");
        $this->addLink("post/logout.php", "Logout");
    }
    public function present()
    {
        $html=<<<HTML
        <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message"></p>
</div>
        <form id="userform" name="userform" class="table" method="post" action="post/users.php">
	<p>
	<input type="submit" name="add" id="add" onclick="errorCheckerAdd(event);" value="Add">
	<input type="submit" name="delete" id="delete" onclick="errorCheckerDelete(event);" value="Delete">
	<button type="reset" id="reset" onclick="RemoveErrorMessage();" >Clear Selection</button>
	</p>
<table>
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
HTML;

        $users = new Users($this->site);
       $all= $users->getUsers();
       // var_dump($all);
        foreach($all as $user)
        {
            $id = $user->getId();
            $name = $user->getName();
            $email = $user->getEmail();
            $role = $user->getRole();
       $html.=<<<HTML
            <tr>
            <td><input type="radio" name="id" value="$id"></td>
            <td><a href="user.php?id=$id">$name</a></td>
            <td>$email</td>
            <td>$role</td>
</tr>
HTML;
        }
        $html.=<<<HTML
	</table>

HTML;
        return $html;

    }

}