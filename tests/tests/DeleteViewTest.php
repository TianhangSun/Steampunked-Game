<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */

class DeleteViewTest extends \PHPUnit_Extensions_Database_TestCase
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

		$users = new Steampunked\DeleteView(self::$site);

		$this->assertInstanceOf('Steampunked\DeleteView', $users);

		//$session[Steampunked\User::SESSION_NAME];
		$html = $users->header();
		$this->assertContains('<nav>', $html);
		$this->assertContains('<ul class="left">', $html);
		$this->assertContains('<li><a href="./">Steampunked Game</a></li>', $html);
		$this->assertContains('</ul>', $html);
		$this->assertContains('<ul class="right"><li><a href="users.php">Users</a></li><li><a href="post/logout.php">Logout</a></li></ul>', $html);
		$this->assertContains('</nav>', $html);
		$this->assertContains('<header class="main">', $html);
		$this->assertContains('</header>', $html);

	}
	public function test_present()
	{
		$users = new Steampunked\DeleteView(self::$site);

		$this->assertInstanceOf('Steampunked\DeleteView', $users);
		$html = $users->present();
		$user = new \Steampunked\Users(self::$site);
		//No id present to get
		$text=<<<HTML
<div id="alert" class="alerts">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <p id="message">ERROR! ID DOESN'T EXIST!</p>
</div>
HTML;

		$this->assertContains($text, $html);
		//Cant test other way as get isn't in  constructor
	}
}

/// @endcond
?>
