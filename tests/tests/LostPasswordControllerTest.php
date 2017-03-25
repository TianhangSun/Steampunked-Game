<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class LostPasswordControllerTest extends \PHPUnit_Extensions_Database_TestCase
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
	public function getDataSet()
	{
		return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();

		//return $this->createFlatXMLDataSet(dirname(__FILE__) .
		//	'/db/users.xml');
	}
	private static $site;

	public static function setUpBeforeClass()
	{
		self::$site = new Steampunked\Site();
		$localize = require 'localize.inc.php';
		if (is_callable($localize)) {
			$localize(self::$site);
		}
	}
	public function test_construct(){
		$root = self::$site->getRoot();
		$root2 = $root.'?e';
		$controller = new Steampunked\LostPasswordController(self::$site, array(
			'email' => 'dudess@dude.com'
		));
		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller);
		$this->assertEquals($root, $controller->getRedirect());
		$controller = new Steampunked\LostPasswordController(self::$site, array(
			'email' => 'marge@dude.com'
		));
		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller);
		$this->assertEquals($root2, $controller->getRedirect());
	}
}

/// @endcond
?>
