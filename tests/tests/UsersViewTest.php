<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class UsersViewTest extends \PHPUnit_Extensions_Database_TestCase
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
		$users = new Steampunked\UsersView(self::$site);
		$this->assertInstanceOf('Steampunked\UsersView', $users);
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
		$users = new Steampunked\UsersView(self::$site);
		$html = $users->present();
		$text = " <div class=\"alert\">
  <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
  <p id=\"message\"></p>
</div>";
		$this->assertContains($text, $html);
		$text2 = <<<HTML
 <form id="userform" name="userform" class="table" method="post" action="post/users.php">
	<p>
	<input type="submit" name="add" id="add" onclick="errorCheckerAdd(event);" value="Add">
	<input type="submit" name="delete" id="delete" onclick="errorCheckerDelete(event);" value="Delete">
	<button type="reset" id="reset" onclick="RemoveErrorMessage();" >Clear Selection</button>
	</p>
<table>
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
HTML;
		$this->assertContains($text2, $html);
		$getusers = new \Steampunked\Users(self::$site);
		$all= $getusers->getUsers();
		// var_dump($all);
		foreach($all as $user)
		{
			$id = $user->getId();
			$name = $user->getName();
			$email = $user->getEmail();
			$role = $user->getRole();
			$text3=<<<HTML
            <tr>
            <td><input type="radio" name="id" value="$id"></td>
            <td><a href="user.php?id=$id">$name</a></td>
            <td>$email</td>
            <td>$role</td>
</tr>
HTML;
		}

		$this->assertContains($text3,$html);
		$text4= "</table>";
		$this->assertContains($text4, $html);

	}

}

/// @endcond
?>
