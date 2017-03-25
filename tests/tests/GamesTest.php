<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class GamesTest extends \PHPUnit_Extensions_Database_TestCase
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

	public static function setUpBeforeClass() {
		self::$site = new Steampunked\Site();
		$localize  = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize(self::$site);
		}
	}
	public function test_construct() {
		$Games = new Steampunked\Games(self::$site);

		$this->assertInstanceOf('Steampunked\Games', $Games);
		$this->assertEquals("testProj2_Game", $Games->getTableName());

	}

	public function test_createGame_getElements(){
		$game = new Steampunked\Games(self::$site);
		$game->createGame("p1","p2","20");
		$id = $game->getId()['id'];

		$names = $game->getName($id);
		$this->assertEquals($names['name'],"p1");
		$this->assertEquals($names['name2'],"p2");

		$winner = $game->getWinner($id);
		$this->assertEquals($winner['winner'],"0");

		$turn = $game->getTurn($id);
		$this->assertEquals($turn['turn'],"0");

		$size = $game->getSize($id);
		$this->assertEquals($size['size'], "20");

		$game->clear($id);
	}

	public function test_hide_available(){
		$game = new Steampunked\Games(self::$site);
		$game->createGame("p1","p2","20");
		$id = $game->getId()['id'];

		$game->createGame("p3","p4","10");
		$id2 = $game->getId()['id'];

		$available = $game->available();
		$this->assertEquals(sizeOf($available),2);

		$game->hide($id);
		$available2 = $game->available();
		$this->assertEquals(sizeOf($available2),1);

		$game->hide($id2);
		$available3 = $game->available();
		$this->assertEquals(sizeOf($available3),0);

		$game->clear($id);
		$game->clear($id2);
	}

	public function test_set_clear(){
		$game = new Steampunked\Games(self::$site);
		$game->createGame("p1","p2","20");
		$id = $game->getId()['id'];

		$names = $game->getName($id);
		$this->assertEquals($names['name'],"p1");
		$this->assertEquals($names['name2'],"p2");
		$game->setName2("p4",$id);
		$names2 = $game->getName($id);
		$this->assertEquals($names2['name'],"p1");
		$this->assertEquals($names2['name2'],"p4");

		$winner = $game->getWinner($id);
		$this->assertEquals($winner['winner'],"0");
		$game->setWinner($id,2);
		$winner2 = $game->getWinner($id);
		$this->assertEquals($winner2['winner'],"2");

		$turn = $game->getTurn($id);
		$this->assertEquals($turn['turn'],"0");
		$game->setTurn($id,1);
		$turn2 = $game->getTurn($id);
		$this->assertEquals($turn2['turn'],"1");

		$game->clear($id);
		$new_id = $game->getId();
		$this->assertEquals($new_id,array());
	}

}

/// @endcond
?>