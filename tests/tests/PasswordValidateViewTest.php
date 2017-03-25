<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */

class PasswordValidateViewTest extends \PHPUnit_Extensions_Database_TestCase
{
	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	public function getConnection()
	{
		return $this->createDefaultDBConnection(self::$site->pdo(), 'mateene');
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet()
	{
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
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

		$users = new Steampunked\PasswordValidateView(self::$site, $_GET);

		$this->assertInstanceOf('Steampunked\PasswordValidateView', $users);


	}
	public function test_present()
	{
		$users = new Steampunked\PasswordValidateView(self::$site, $_GET);

		$this->assertInstanceOf('Steampunked\PasswordValidateView', $users);
		$html = $users->present();
		$user = new \Steampunked\Users(self::$site);
		//No id present to get
		$text=<<<HTML
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
		    <input type="hidden" name="validator" id="validator" value="">
			<input type="submit" name="add" onclick="validatorForm(event);" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
        </form>
HTML;

		$this->assertContains($text, $html);
		//Cant test other way as get isn't in  constructor
	}
}

/// @endcond
?>
