<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */


class PasswordValidateControllerTest extends \PHPUnit_Extensions_Database_TestCase
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

		$controller2 = new Steampunked\LostPasswordController(self::$site, array(
			'email' => 'dudess@dude.com'
		));
		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller2);
		$this->assertEquals($root, $controller2->getRedirect());
		$row = array('email' => 'dudess@dude.com',
			'password' => '12345678',
			'password2' => '1235678',
			'add' => 'OK',
			'validator' => ''

		);
		$controller = new Steampunked\PasswordValidateController(self::$site, $row);

		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\PasswordValidateController', $controller);
		$this->assertEquals($root.'/password-validate.php?e2', $controller->getRedirect());


		$controller2 = new Steampunked\LostPasswordController(self::$site, array(
			'email' => 'dudess@dude.com'
		));
		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller2);
		$this->assertEquals($root, $controller2->getRedirect());
		$row = array('email' => 'dudess@dude.com',
			'password' => '1233355',
			'password2' => '1235678',
			'add' => 'OK',
			'validator' => 'ymoa9XFZFOIvzjGmuSitRsvUxse2rqdf'

		);
		$controller = new Steampunked\PasswordValidateController(self::$site, $row);

		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\PasswordValidateController', $controller);
		$this->assertEquals($root.'/password-validate.php?e2', $controller->getRedirect());
		$controller2 = new Steampunked\LostPasswordController(self::$site, array(
			'email' => 'dudess@dude.com'
		));
		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller2);
		$this->assertEquals($root, $controller2->getRedirect());
		$row = array('email' => 'dudess@dude.com',
			'password' => '12345678',
			'password2' => '12345678',
			'add' => 'OK',
			'validator' => 'ymoa9XFZFOIvzjGmuSitRsvUxse2rqdf'

		);
		$controller = new Steampunked\PasswordValidateController(self::$site, $row);

		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\PasswordValidateController', $controller);
		$this->assertEquals($root, $controller->getRedirect());

		$this->assertInstanceOf('Steampunked\LostPasswordController', $controller2);
		$this->assertEquals($root, $controller2->getRedirect());
		$row = array('email' => 'dudess@dude.com',
			'password' => '123456',
			'password2' => '123456',
			'add' => 'OK',
			'validator' => 'ymoa9XFZFOIvzjGmuSitRsvUxse2rqdf'

		);
		$controller = new Steampunked\PasswordValidateController(self::$site, $row);

		//$insert =$users->add($user,$mailer);
		$this->assertInstanceOf('Steampunked\PasswordValidateController', $controller);
		$this->assertEquals($root.'/password-validate.php?e3', $controller->getRedirect());


	}
}

/// @endcond
?>
