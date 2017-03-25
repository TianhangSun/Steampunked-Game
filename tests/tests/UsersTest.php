<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */
require 'EmailMock.php';
class UsersTest extends \PHPUnit_Extensions_Database_TestCase
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
		$users = new Steampunked\Users(self::$site);
		$this->assertInstanceOf('Steampunked\Users', $users);
	}
	public function test_login() {
		$users = new Steampunked\Users(self::$site);

		// Test a valid login based on user ID
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertInstanceOf('Steampunked\User', $user);
		$this->assertEquals($user->getEmail(),"dudess@dude.com");
		// Test a valid login based on email address
		$user = $users->login("cbowen@cse.msu.edu", "super477");
		$this->assertInstanceOf('Steampunked\User', $user);

		// Test a failed login
		$user = $users->login("dudess@dude.com", "wrongpw");
		$this->assertNull($user);


	}
	public function test_getid()
	{
		$users = new Steampunked\Users(self::$site);

		$user = $users->get(8);
		$this->assertInstanceOf('Steampunked\User', $user);
		$user = $users->get(6);
		$this->assertNull($user);
	}

	public function test_exists() {
		$users = new Steampunked\Users(self::$site);

		$this->assertTrue($users->exists("dudess@dude.com"));
		$this->assertFalse($users->exists("dudess"));
		$this->assertFalse($users->exists("cbowen"));
		$this->assertTrue($users->exists("cbowen@cse.msu.edu"));
		$this->assertFalse($users->exists("nobody"));
		$this->assertFalse($users->exists("7"));
	}
	public function other_exists() {
		$users = new \Steampunked\Users(self::$site);
		$user = $users->login("dudess@dude.com", "87654321");
		assertTrue($users->other_exist("cbowen@cse.msu.edu"));
		assertFalse($users->other_exist("dudess@dude.com"));
	}
	public function test_add() {
		$users = new Steampunked\Users(self::$site);

		$mailer = new EmailMock();

		$user7 = $users->get(7);
		$this->assertContains("Email address already exists",
			$users->add($user7, $mailer));
		$row = array('id' => 0,
			'email' => 'dude@ranch.com',
			'name' => 'Dude, The',

			'password' => '12345678',

			'role' => 'G'
		);
		$user = new Steampunked\User($row);
		$users->add($user, $mailer);

		$table = $users->getTableName();
		$sql = <<<SQL
select * from $table where email='dude@ranch.com'
SQL;

		$stmt = $users->pdo()->prepare($sql);
		$stmt->execute();
		$this->assertEquals(1, $stmt->rowCount());
		$this->assertEquals("dude@ranch.com", $mailer->to);
		$this->assertEquals("Confirm your email", $mailer->subject);
	}
	public function test_setPassword() {
		$users = new Steampunked\Users(self::$site);

		// Test a valid login based on user ID
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertNotNull($user);
		$this->assertEquals("Dudess, The", $user->getName());

		// Change the password
		$users->setPassword(7, "dFcCkJ6t");

		// Old password should not work
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertNull($user);
		//echo $users->get_salt();
		// New password does work!
		$user = $users->login("dudess@dude.com", "dFcCkJ6t");

		$this->assertNotNull($user);
		$this->assertEquals("Dudess, The", $user->getName());
	}
public function test_delete() {
	$users = new Steampunked\Users(self::$site);

	// Test a valid login based on user ID
	$user = $users->login("dudess@dude.com", "87654321");
	$this->assertTrue($users->exists("marge@bartman.com"));
	// delete user with email  marge@bartman.com
	$users->delete(10);
	$this->assertFalse($users->exists("marge@bartman.com"));
	$this->assertTrue($users->exists("cbowen@cse.msu.edu"));
}
	public function test_update()
	{
		$users = new Steampunked\Users(self::$site);

		//Make Sure its not equal to any of the old values
		$this->assertEquals("Simpson, Marge", $users->get(10)->getName());
		$this->assertEquals("marge@bartman.com", $users->get(10)->getEmail());
		$this->assertEquals("G", $users->get(10)->getRole());
		// update user with email  marge@bartman.com
		$row = array('id' => 10,
			'email' => 'marge@marge.com',
			'name' => 'Marge Simpson',
			'role' => 'A'
		);
		$user = new Steampunked\User($row);
		$users->update($user);
		//Test new values
		$this->assertEquals("Marge Simpson", $users->get(10)->getName());
		$this->assertEquals("marge@marge.com", $users->get(10)->getEmail());
		$this->assertEquals("A", $users->get(10)->getRole());
	}
	public function test_getUser()
	{
		$users = new Steampunked\Users(self::$site);
		$user = $users->getUsers();

		$this->assertEquals(4, count($user));
	}
}

/// @endcond
?>
