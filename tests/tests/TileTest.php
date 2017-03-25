<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class TileTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct(){
		$Tile = new Steampunked\Tile(array(
			'id' => 'testid',
			'name' => 'testname',
			'x' => 'testx',
			'y' => 'testy'));

		$this->assertInstanceOf('Steampunked\Tile', $Tile);

		//test getters
		$this->assertEquals("testid", $Tile->getId());
		$this->assertEquals("testname", $Tile->getName());
		$this->assertEquals("testx", $Tile->getX());
		$this->assertEquals("testy", $Tile->getY());
	}
}

/// @endcond
?>
