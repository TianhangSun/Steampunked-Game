<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class UsersControllerTest extends \PHPUnit_Extensions_Database_TestCase
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

		//	$site = new Steampunked\Site();
		$controller = new Steampunked\UsersController(self::$site, array(
			'add'=>'Add',
			'id'=>'1',
			'delete'=>''
			));

		$this->assertInstanceOf('Steampunked\UsersController', $controller);
		$this->assertEquals($root.'/users.php?e', $controller->getRedirect());

		$controller = new Steampunked\UsersController(self::$site, array(
			'add'=>'Add',
			'id'=>'0',
			'delete'=>''));

		$this->assertInstanceOf('Steampunked\UsersController', $controller);
		$this->assertEquals($root.'/user.php', $controller->getRedirect());

		$controller = new Steampunked\UsersController(self::$site, array(
			'add'=>'Add',
			'id'=>null,
			'delete'=>''));

		$this->assertInstanceOf('Steampunked\UsersController', $controller);
		$this->assertEquals($root.'/user.php', $controller->getRedirect());

		$controller = new Steampunked\UsersController(self::$site, array(
			'delete'=>'Delete',
			'id'=>null,
			'add'=>''));

		$this->assertInstanceOf('Steampunked\UsersController', $controller);
		$this->assertEquals($root.'/users.php?e', $controller->getRedirect());
		$controller = new Steampunked\UsersController(self::$site, array(
			'delete'=>'Delete',
			'id'=>5,
			'add'=>''));

		$this->assertInstanceOf('Steampunked\UsersController', $controller);
		$this->assertEquals($root.'/delete-user.php?id=5', $controller->getRedirect());
	}
}

/// @endcond
?>
