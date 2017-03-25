<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class ViewTest extends \PHPUnit_Extensions_Database_TestCase
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
	public function test_header() {
		$view = new Steampunked\View();
		$view->setTitle("Steampunked Game");
		$this->assertContains("<title>Steampunked Game</title>", $view->head());
		$html = $view->header();

		$this->assertContains('<nav>', $html);
		$this->assertContains('<ul class="left">', $html);
		$this->assertContains('<li><a href="./">Steampunked Game</a></li>', $html);
		$this->assertContains('</ul>', $html);
		$this->assertContains('</nav>', $html);
		$this->assertContains('<header class="main">', $html);
		$this->assertContains('</header>', $html);

		$this->assertNotContains('<ul class="right">', $html);
	echo $html;
	}
	public function test_addLink() {
		$view = new Steampunked\View();
		$view->setTitle("whatever");
		$view->addLink("test.php", "Name to Display");
		$html = $view->header();

		$this->assertContains('<ul class="right"><li><a href="test.php">Name to Display</a></li></ul>', $html);
	}

	public function test_protected()
	{
		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertTrue($view->protect(self::$site, $user));

		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = $users->login("marge@bartman.com", "marge477");
		$this->assertFalse($view->protect(self::$site, $user));
		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = null;
		$this->assertFalse($view->protect(self::$site, $user));
	}
	public function test_getCurrentRole()
	{
		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertTrue($view->getCurrentUserId(self::$site, 7, $user));
		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = $users->login("marge@bartman.com", "marge477");
		$this->assertFalse($view->getCurrentUserId(self::$site, 9,  $user));
		$users = new \Steampunked\Users(self::$site);
		$view = new \Steampunked\View(self::$site);
		$user = $users->login("marge@bartman.com", "marge477");
		$this->assertFalse($view->getCurrentUserId(self::$site, 9,  null));
	}
}

/// @endcond
?>
