<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 3:31 PM
 */

namespace Steampunked;


class PasswordValidateView extends View
{
    public function __construct(Site $site, array $get)
    {
        $this->site = $site;
        $this->setTitle("Felis Password Entry");
        if (isset($_GET['v'])) {
            $this->validator = strip_tags($_GET['v']);
        }
    }
    public function present()
    {
        $html = <<<HTML
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message"></p>
</div>
<form id="validatorform" name="validatorform" method="post" action="post/password-validate.php">
	<fieldset>
		<legend>Change Password</legend>
		<p>
			<label for="email">Email:</label><br>
			<input type="email" id="email" name="email" value="" placeholder="Email" required>
		</p>
		<p>
			<label for="name">Password:</label><br>
			<input type="password" id="password" name="password" value="" placeholder="password">
		</p>
		<p>
			<label for="name">Password(again):</label><br>
			<input type="password" id="password2" name="password2" value="" placeholder="password(again)">
		</p>
		<p>
		    <input type="hidden" name="validator" id="validator" value="$this->validator">
			<input type="submit" name="add" onclick="validatorForm(event);" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
        </form>
HTML;
        return $html;
    }
    private $validator;
}