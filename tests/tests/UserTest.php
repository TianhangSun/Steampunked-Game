<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$user = new Steampunked\User( array(
			'id' => 'idtest',
			'email' => 'emailtest',
			'name' => 'nametest',
			'role' => 'roletest'));

		$this->assertInstanceOf('Steampunked\User', $user);
		$this->assertEquals('idtest', $user->getId());

		$this->assertEquals('emailtest', $user->getEmail());
		$user->setEmail('new_email_test2');
		$this->assertEquals('new_email_test2', $user->getEmail());

		$this->assertEquals('nametest', $user->getName());
		$user->setName('new_name_test2');
		$this->assertEquals('new_name_test2', $user->getName());

		$this->assertEquals('roletest', $user->getRole());
		$user->setRole('new_role_test2');
		$this->assertEquals('new_role_test2', $user->getRole());
	}
	public function test_isGamer(){
		$user = new Steampunked\User( array(
			'id' => 'idtest',
			'email' => 'emailtest',
			'name' => 'nametest',
			'role' => 'testrole'));
		$this->assertFalse($user->isGamer());
		$user->setRole('A');
		$this->assertTrue($user->isGamer());
		$user->setRole('G');
		$this->assertTrue($user->isGamer());

	}
}

/// @endcond
?>
