<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class SteampunkedViewTest extends \PHPUnit_Extensions_Database_TestCase
{	const SEED = 1422668587;

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

	public function test_construct(){
		//require_once 'lib/Steampunked/SteampunkedView.php';
		$steampunked = new \Steampunked\Steampunked(SELF::SEED);
		$steampunked->setSize(6);
		$steampunked->constructGame(6);
		$game = new Steampunked\Games(self::$site);
		$game->createGame("p1","p2","6");
		$id = $game->getId()['id'];
		$game->setTurn($id,"1");
		$steampunked->setId($id);
		$steampunked->setPlayerNum(1);
		$view = new Steampunked\SteampunkedView($steampunked,self::$site);

		$this->assertInstanceOf('Steampunked\SteampunkedView', $view);
		$game->clear($id);
	}
	public function getHtml(){
		$steampunked = new \Steampunked\Steampunked(SELF::SEED);
		$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$steampunked->setSize(6);
		$steampunked->constructGame(6);
		$game = new Steampunked\Games(self::$site);
		$game->createGame("Mateen","Jack","6");
		$id = $game->getId()['id'];
		$game->setTurn($id,"1");
		$steampunked->setId($id);
		$steampunked->setPlayerNum(1);
		$steampunked->setPlayerName("Mateen", "Jack");
		$this->assertContains("Player 1:", $view->getHtml());
		$this->assertContains("leakE", $view->getHtml());
		$this->assertContains("valve-closed.png", $view->getHtml());
		$this->assertContains("rotate", $view->getHtml());
		$this->assertContains("discard", $view->getHtml());
		$this->assertContains("open_valve", $view->getHtml());
		$this->assertContains("radio", $view->getHtml());
		$game->clear($id);
	}
	public function test_buttons(){
		$steampunked = new \Steampunked\Steampunked(SELF::SEED);
		$steampunked->constructGame();
		$game = new Steampunked\Games(self::$site);
		$game->createGame("Mateen","Jack","6");
		$id = $game->getId()['id'];
		$game->setTurn($id,"1");
		$steampunked->setId($id);
		$steampunked->setPlayerNum(1);
		$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$this->assertContains("Rotate", $view->getHtml());
		$this->assertContains("Discard", $view->getHtml());
		$this->assertContains("Open Valve", $view->getHtml());
		$this->assertContains("Give Up", $view->getHtml());
		$game->clear($id);
	}
	public function test_getWinner(){
		$steampunked = new \Steampunked\Steampunked(SELF::SEED);
		//$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$steampunked->setSize(6);
		$steampunked->constructGame(6);
		$game = new Steampunked\Games(self::$site);
		$game->createGame("Mateen","Jack","6");
		$id = $game->getId()['id'];
		$game->setTurn($id,"1");
		$steampunked->setId($id);
		$steampunked->setPlayerNum(1);
		$steampunked->setPlayerName("Mateen", "Jack");
		$steampunked->setWinner(1);
		$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$this->assertContains("Player 1:" ,$view->getWinner());
		$this->assertContains("Mateen", $view->getWinner());
		$this->assertContains("Wins the Game!" ,$view->getWinner());
		$this->assertNotContains("Player 2:", $view->getWinner());
		$this->assertNotContains("Jack", $view->getWinner());

		$steampunked = new \Steampunked\Steampunked(SELF::SEED);
		//$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$steampunked->setSize(6);
		$steampunked->constructGame(6);
		$game->createGame("Mateen","Jack","6");
		$id2 = $game->getId()['id'];
		$game->setTurn($id2,"1");
		$steampunked->setId($id2);
		$steampunked->setPlayerNum(1);
		$steampunked->setPlayerName("Mateen", "Jack");
		$steampunked->setWinner(0);
		$view = new Steampunked\SteampunkedView($steampunked,self::$site);
		$this->assertNotContains("Player 2:" ,$view->getWinner());
		$this->assertNotContains("Mateen", $view->getWinner());
		$this->assertNotContains("Player 1:", $view->getWinner());
		$this->assertNotContains("Jack", $view->getWinner());
		$game->clear($id);
		$game->clear($id2);
	}

}

/// @endcond
?>
