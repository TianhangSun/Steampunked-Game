<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class UserViewTest extends \PHPUnit_Extensions_Database_TestCase
{
	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	public function getConnection()
	{
		return $this->createDefaultDBConnection(self::$site->pdo(), 'suntianh');
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet()
	{
		return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();
	}
	private static $site;

	public static function setUpBeforeClass() {
		self::$site = new Steampunked\Site();
		$localize  = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize(self::$site);
		}
	}
	public function test_construct() {

		$users = new Steampunked\UserView(self::$site, $_GET);

		$this->assertInstanceOf('Steampunked\UserView', $users);

		//$session[Steampunked\User::SESSION_NAME];
		$html = $users->header();
		$this->assertContains('<nav>', $html);
		$this->assertContains('<ul class="left">', $html);
		$this->assertContains('<li><a href="./">Steampunked Game</a></li>', $html);
		$this->assertContains('</ul>', $html);
		$this->assertContains('<ul class="right"><li><a href="post/logout.php">Logout</a></li></ul>', $html);
		$this->assertContains('</nav>', $html);
		$this->assertContains('<header class="main">', $html);
		$this->assertContains('</header>', $html);

	}
	public function test_present()
	{
		$text=<<<HTML
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
        <input type="submit" value="Cancel" onclick="cancel(event);" formnovalidate>
        <input type="hidden" value="" name="id" id="id">
        <input type="hidden" value="G" id="role" name="role"> </p>
    </fieldset>
</form>
HTML;
		$users = new Steampunked\UserView(self::$site, $_GET);

		$this->assertInstanceOf('Steampunked\UserView', $users);
		$html = $users->present();
		$this->assertContains($text, $html);
	}
}

/// @endcond
?>
