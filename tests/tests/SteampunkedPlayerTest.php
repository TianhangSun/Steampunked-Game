<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class SteampunkedPlayerTest extends \PHPUnit_Framework_TestCase
{
	const SEED = 1422668587;
	public function test_construct(){
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();

		$this->assertInstanceOf('Steampunked\SteampunkPlayer', $player);
	}
	public function test_switchPlayer(){
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();
		$this->assertEquals(1,$player->getPlayerTurn());
		$this->assertNotEquals(null, $player->getPlayerTurn());
		$player->switchPlayer();
		$this->assertEquals(2,$player->getPlayerTurn());
		$this->assertNotEquals(null, $player->getPlayerTurn());
		$player->switchPlayer();
		$this->assertEquals(1,$player->getPlayerTurn());
		$this->assertNotEquals(null, $player->getPlayerTurn());


	}
	public function test_getPlayerTurn()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();
		$this->assertEquals(1,$player->getPlayerTurn());
		$this->assertNotEquals(2,$player->getPlayerTurn());
		$player->switchPlayer();
		$this->assertEquals(2,$player->getPlayerTurn());
		$this->assertNotEquals(1,$player->getPlayerTurn());

	}
	public function test_getRandomPipe()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();

	}
	public function test_getPipe()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$pipe1 = $steampunk->getPlayer()->getPipes(1);
		$steampunk->switchPlayer();
		$steampunk->switchPlayer();
		$pipe2 = $steampunk->getPlayer()->getPipes(1);
		$this->assertEquals($pipe1[0]->getId(), $pipe2[0]->getId());
		$this->assertEquals($pipe1[1]->getId(), $pipe2[1]->getId());
		$this->assertEquals($pipe1[2]->getId(), $pipe2[2]->getId());
		$this->assertEquals($pipe1[3]->getId(), $pipe2[3]->getId());
		$this->assertEquals($pipe1[4]->getId(), $pipe2[4]->getId());

	}
	public function test_rotateTile()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$player = $steampunk->getPlayer();
		$pipe1 = $player->getPipes(1);
		$player->rotateTile(0);
		$this->assertEquals($pipe1[0]->getId(),'ninety-sw.png');
		$player->rotateTile(0);
		$pipe2 = $player->getPipes(1);
		$this->assertEquals($pipe2[0]->getId(),'ninety-wn.png');

	}
	public function test_PlayerName()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();
		$p1 = "Mateen";
		$p2 = "John";
		$player->setPlayerName($p1,$p2);
		$this->assertEquals("Mateen",$player->getPlayerName());
		$this->assertNotEquals("John",$player->getPlayerName());
		$player->switchPlayer();
		$this->assertEquals("John",$player->getPlayerName());
		$this->assertNotEquals("Mateen",$player->getPlayerName());
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();
		$p1 = "";
		$p2 = "";
		$player->setPlayerName($p1,$p2);
		$this->assertEquals("Player 1",$player->getPlayerName());
		$this->assertNotEquals("Player 2",$player->getPlayerName());
		$player->switchPlayer();
		$this->assertEquals("Player 2",$player->getPlayerName());
		$this->assertNotEquals("Player 1",$player->getPlayerName());

	}
	public function test_WinnerName()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$player = new Steampunked\SteampunkPlayer();
		$p1 = "Mateen";
		$p2 = "John";
		$player->setPlayerName($p1,$p2);
		$winner = 1;
		$player->getWinnerName($winner);
		$this->assertEquals("Mateen",$player->getWinnerName(1));
		$winner=2;
		$player->getWinnerName($winner);
		$this->assertEquals("John",$player->getWinnerName(2));
		$winner = null;
		$this->assertNotEquals("John",$player->getWinnerName($winner));
		$this->assertNotEquals("Mateen",$player->getWinnerName($winner));
		$winner ="";
		$this->assertNotEquals("John",$player->getWinnerName($winner));
		$this->assertNotEquals("Mateen",$player->getWinnerName($winner));
	}
	public function test_updateHand()
	{
		$steampunk = new \Steampunked\Steampunked(self::SEED);
		$steampunk->setSize(6);
		$pipe1 = $steampunk->getPlayer()->getPipes(1);
		$steampunk->getPlayer()->updateHand(0);
		$steampunk->getPlayer()->updateHand(0);
		$steampunk->getPlayer()->updateHand(0);
		$pipe2 = $steampunk->getPlayer()->getPipes(1);
		$this->assertNotEquals($pipe1[0]->getId(), $pipe2[0]->getId());
		$this->assertEquals($pipe1[1]->getId(), $pipe2[1]->getId());
		$this->assertEquals($pipe1[2]->getId(), $pipe2[2]->getId());
		$this->assertEquals($pipe1[3]->getId(), $pipe2[3]->getId());
		$this->assertEquals($pipe1[4]->getId(), $pipe2[4]->getId());

	}
}

/// @endcond
?>
