<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";
class SteampunkedTest extends \PHPUnit_Framework_TestCase
{
	const SEED = 1422668587;

	public function test_construct() {
		 $steampunk = new Steampunked\Steampunked(self::SEED);

		$this->assertInstanceOf('Steampunked\Steampunked', $steampunk);

	}
	public function test_Size(){
		//Tests setSize and GetSize
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$steampunked->setSize(6);
		$this->assertEquals(6, $steampunked->getSize());
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$steampunked->setSize(10);
		$this->assertEquals(10, $steampunked->getSize());
		$steampunked->setSize(20);
		$this->assertEquals(20,$steampunked->getSize());
		$steampunked->setSize(50); //Invalid Size
		$this->assertNotEquals(50,$steampunked->getSize());
		$steampunked->setSize(0); //Invalid Size
		$this->assertNotEquals(0,$steampunked->getSize());
		$steampunked->setSize(null); //Invalid Size
		$this->assertNotEquals(null,$steampunked->getSize());

	}
	public function test_constructGame()
	{
		//Needs More Testing
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$steampunk->constructGame(6);
		$this->assertEquals(6,$steampunk->getSize());
		$this->assertInstanceOf('Steampunked\SteampunkPlayer', $steampunk->getPlayer());
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(10);
		$this->assertInstanceOf('Steampunked\SteampunkPlayer', $steampunk->getPlayer());
	//	$steampunk->constructGame(e);
	//	$this->assertNotEquals(6,$steampunk->constructGame());
	}
	public function test_player()
	{
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$player = new \Steampunked\SteampunkPlayer();
		$steampunk->setSize(6);
		$steampunk->constructGame(6);

		$this->assertInstanceOf('Steampunked\SteampunkPlayer', $steampunk->getPlayer());
		$steampunk->setPlayerName("Mateen","John");
		$this->assertEquals("Mateen", $steampunk->getPlayer()->getPlayerName());
		$steampunk->switchPlayer();
		$this->assertEquals("John", $steampunk->getPlayer()->getPlayerName());

		$this->assertEquals(2,$steampunk->getPlayer()->getPlayerTurn());
		$steampunk->switchPlayer();
		$this->assertEquals(1,$steampunk->getPlayer()->getPlayerTurn());
		$this->assertNotEquals(2,$steampunk->getPlayer()->getPlayerTurn());
		$this->assertNotEquals(null,$steampunk->getPlayer()->getPlayerTurn());
		$steampunk->setWinner(1);
		$this->assertEquals("Mateen",$steampunk->getWinnerName(1));
		$this->assertEquals(1,$steampunk->getWinner());
		$this->assertNotEquals(2,$steampunk->getWinner());
		$this->assertNotEquals(null, $steampunk->getWinner());
		$this->assertNotEquals("John",$steampunk->getWinnerName(1));
		$steampunk->setWinner(2);
		$this->assertEquals("John",$steampunk->getWinnerName(2));
		$this->assertEquals(2,$steampunk->getWinner());
		$this->assertNotEquals(1,$steampunk->getWinner());
		$this->assertNotEquals(null, $steampunk->getWinner());
		$this->assertNotEquals("Mateen",$steampunk->getWinnerName(2));
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$player = new \Steampunked\SteampunkPlayer();
		$steampunk->setSize(6);
		$steampunk->constructGame(6);
		$steampunk->setPlayerName("","");
		$this->assertEquals("Player 1", $steampunk->getPlayer()->getPlayerName());
		$steampunk->switchPlayer();
		$this->assertEquals("Player 2", $steampunk->getPlayer()->getPlayerName());

		$this->assertEquals(2,$steampunk->getPlayer()->getPlayerTurn());
		$steampunk->switchPlayer();
		$this->assertEquals(1,$steampunk->getPlayer()->getPlayerTurn());
		$this->assertNotEquals(2,$steampunk->getPlayer()->getPlayerTurn());
		$this->assertNotEquals(null,$steampunk->getPlayer()->getPlayerTurn());
		$steampunk->setWinner(1);
		$this->assertEquals("Player 1",$steampunk->getWinnerName(1));
		$this->assertEquals(1,$steampunk->getWinner());
		$this->assertNotEquals(2,$steampunk->getWinner());
		$this->assertNotEquals(null, $steampunk->getWinner());
		$this->assertNotEquals("Player 2",$steampunk->getWinnerName(1));
		$steampunk->setWinner(2);
		$this->assertEquals("Player 2",$steampunk->getWinnerName(2));
		$this->assertEquals(2,$steampunk->getWinner());
		$this->assertNotEquals(1,$steampunk->getWinner());
		$this->assertNotEquals(null, $steampunk->getWinner());
		$this->assertNotEquals("Player 1",$steampunk->getWinnerName(2));

	}
	public function test_game()
	{
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$steampunk->constructGame(6);
		$steampunk->setGame(3,3,"leak");
		$this->assertEquals($steampunk->getGame()[3][3], "leak");

	}
	public function test_FinkLeaks()
	{
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$steampunk->constructGame(6);

		$steampunk->setGame(0,1,"others");
		$this->assertEquals($steampunk->getGame()[0][1], "others");
		$steampunk->Findleaks(1);
		$this->assertEquals($steampunk->getGame()[0][1], "leak");

	}
	public function test_FindPlayerLeaks()
	{
		$steampunk = new Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$steampunk->constructGame(6);
		$steampunk->findPlayerLeak(1);
		$this->assertEquals($steampunk->getWinner(), 2);

	}
	public function updateHand()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$pipe1 = $steampunk->getPlayer()->getPipes();
		$steampunk->updateHand(0);
		$steampunk->updateHand(0);
		$steampunk->updateHand(0);
		$pipe2 = $steampunk->getPlayer()->getPipes();
		$this->assertNotEquals($pipe1[0]->getId(), $pipe2[0]->getId());
		$this->assertEquals($pipe1[1]->getId(), $pipe2[1]->getId());
		$this->assertEquals($pipe1[2]->getId(), $pipe2[2]->getId());
		$this->assertEquals($pipe1[3]->getId(), $pipe2[3]->getId());
		$this->assertEquals($pipe1[4]->getId(), $pipe2[4]->getId());
	}

	public function test_get_set(){
		$steampunk = new \Steampunked\Steampunked(self::SEED);

		$steampunk->setWait(true);
		$wait = $steampunk->getWait();
		$this->assertEquals($wait,true);

		$steampunk->setid(5);
		$id = $steampunk->getId();
		$this->assertEquals($id,5);

		$steampunk->setPlayerNum(3);
		$num = $steampunk->getPlayerNum();
		$this->assertEquals($num,3);

		$steampunk->setCnt(7);
		$cnt = $steampunk->getCnt();
		$this->assertEquals($cnt, 7);
	}


}

/// @endcond
?>
