<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */

require 'EmailMock.php';
class NewUserControllerTest extends \PHPUnit_Extensions_Database_TestCase
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
	public function getDataSet()
	{
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');

		//return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();

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
		$users = new Steampunked\Users(self::$site);

		$row = array('id' => 0,
			'email' => 'dude@ranch.com',
			'name' => 'Dude, The',
			'password' => 12345678,
			'role' => 'G',
			'add' => 'OK'
		);
		$controller = new Steampunked\NewUserController(self::$site, $row);

		$mailer = new EmailMock();

		$user = new \Steampunked\User($row);
	//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\NewUserController', $controller);
		$this->assertEquals($root.'/user.php?id=11', $controller->getRedirect());

		$users = new Steampunked\Users(self::$site);

		$row = array('id' => 0,
			'email' => 'marge@bartman.com',
			'name' => 'Dude, The',
			'password' => 12345678,
			'role' => 'G',
			'add' => 'OK'
		);
		$controller = new Steampunked\NewUserController(self::$site, $row);

		$mailer = new EmailMock();

		$user = new \Steampunked\User($row);
		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\NewUserController', $controller);
		$this->assertEquals($root.'/user.php?e2', $controller->getRedirect());
		$users = new Steampunked\Users(self::$site);

		$row = array('id' => 10,
			'email' => 'marge@bartman.com',
			'name' => 'Dude, The',
			'password' => 12345678,
			'role' => 'G',
			'add' => 'OK'
		);
		$controller = new Steampunked\NewUserController(self::$site, $row);

		$mailer = new EmailMock();

		$user = new \Steampunked\User($row);
		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\NewUserController', $controller);
		$this->assertEquals($root.'/user.php?id=10', $controller->getRedirect());
	}
}

/// @endcond
?>
