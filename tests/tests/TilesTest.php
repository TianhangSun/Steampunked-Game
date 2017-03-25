<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class TilesTest extends \PHPUnit_Extensions_Database_TestCase
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
		$Tiles = new Steampunked\Tiles(self::$site);
		$this->assertInstanceOf('Steampunked\Tiles', $Tiles);
		$this->assertEquals("testProj2_Tile", $Tiles->getTableName());

		//test pdo()
		$this->assertEquals(self::$site->pdo(), $Tiles->pdo());
	}
	public function test_get_add_Tile()
	{
		$tiles = new Steampunked\Tiles(self::$site);
		$tiles->addTile('test_tile', '1', '2', '3', '4');

		$tile = $tiles->getTile("3");
		$this->assertEquals($tile['name'],"test_tile");
		$this->assertEquals($tile['x'],"1");
		$this->assertEquals($tile['y'],"2");

		$tiles->clear("3");
	}

	public function test_getNum_clear(){
		$tiles = new Steampunked\Tiles(self::$site);

		$tiles->addTile('test_tile', '1', '2', '3', '4');
		$num = $tiles->getTileNum("3","4")["count(owner)"];
		$this->assertEquals($num,1);

		$tiles->addTile('test_tile2', '11', '22', '33', '4');
		$num = $tiles->getTileNum("33","4")["count(owner)"];
		$this->assertEquals($num,1);

		$tiles->addTile('test_tile2', '111', '222', '3', '4');
		$num = $tiles->getTileNum("3","4")["count(owner)"];
		$this->assertEquals($num,2);

		$tiles->clear("3");
		$num = $tiles->getTileNum("3","4")["count(owner)"];
		$this->assertEquals($num,0);

		$tiles->clear("33");
		$num = $tiles->getTileNum("33","4")["count(owner)"];
		$this->assertEquals($num,0);
	}


}

/// @endcond
?>
