<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class SteampunkedTileTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");

		$this->assertInstanceOf('Steampunked\SteampunkTile', $tile);
		$this->assertEquals("cap-e.png", $tile->getId());

	}
	public function test_changePicture(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");
		$this->assertEquals(true, $tile->open()["E"]);

		$tile = new Steampunked\SteampunkTile("cap-n.png");
		$this->assertEquals(true, $tile->open()["N"]);

		$tile = new Steampunked\SteampunkTile("cap-s.png");
		$this->assertEquals(true, $tile->open()["S"]);

		$tile = new Steampunked\SteampunkTile("cap-w.png");
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("gauge-0.png");
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("gauge-190.png");
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("ninety-es.png");
		$this->assertEquals(true, $tile->open()["E"]);
		$this->assertEquals(true, $tile->open()["S"]);

		$tile = new Steampunked\SteampunkTile("ninety-ne.png");
		$this->assertEquals(true, $tile->open()["N"]);
		$this->assertEquals(true, $tile->open()["E"]);

		$tile = new Steampunked\SteampunkTile("ninety-sw.png");
		$this->assertEquals(true, $tile->open()["S"]);
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("ninety-wn.png");
		$this->assertEquals(true, $tile->open()["W"]);
		$this->assertEquals(true, $tile->open()["N"]);

		$tile = new Steampunked\SteampunkTile("straight-h.png");
		$this->assertEquals(true, $tile->open()["E"]);
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("straight-v.png");
		$this->assertEquals(true, $tile->open()["N"]);
		$this->assertEquals(true, $tile->open()["S"]);

		$tile = new Steampunked\SteampunkTile("tee-esw.png");
		$this->assertEquals(true, $tile->open()["E"]);
		$this->assertEquals(true, $tile->open()["S"]);
		$this->assertEquals(true, $tile->open()["W"]);

		$tile = new Steampunked\SteampunkTile("tee-nes.png");
		$this->assertEquals(true, $tile->open()["N"]);
		$this->assertEquals(true, $tile->open()["E"]);
		$this->assertEquals(true, $tile->open()["S"]);

		$tile = new Steampunked\SteampunkTile("tee-swn.png");
		$this->assertEquals(true, $tile->open()["S"]);
		$this->assertEquals(true, $tile->open()["W"]);
		$this->assertEquals(true, $tile->open()["N"]);

		$tile = new Steampunked\SteampunkTile("tee-wne.png");
		$this->assertEquals(true, $tile->open()["W"]);
		$this->assertEquals(true, $tile->open()["N"]);
		$this->assertEquals(true, $tile->open()["E"]);

		$tile = new Steampunked\SteampunkTile("valve-open.png");
		$this->assertEquals(true, $tile->open()["E"]);

		$tile = new Steampunked\SteampunkTile("valve-closed.png");
		$this->assertEquals(true, $tile->open()["E"]);
	}
	public function test_indicateLeaks(){

		$t1 = new \Steampunked\SteampunkTile("valve-closed.png");
		$t2 = new \Steampunked\SteampunkTile("straight-h.png");
		$t3 = new \Steampunked\SteampunkTile("gauge-0.png");
		$this->assertEquals("leak", $t3->indicateLeaks());

		$t1->addNeighbor($t2, "E");
		$t2->addNeighbor($t1, "W");
		$t2->addNeighbor($t3, "E");
		$t3->addNeighbor($t2, "W");
		$this->assertEquals(Array(), $t3->indicateLeaks());

	}
	public function test_neighbor(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");

		$this->assertEquals(null, $tile->neighbor("E"));
		$this->assertEquals(null, $tile->neighbor("N"));
		$this->assertEquals(null, $tile->neighbor("S"));
		$this->assertEquals(null, $tile->neighbor("W"));

		$tile->addNeighbor(1, "E");
		$this->assertEquals(1, $tile->neighbor("E"));
	}
	public function test_rotate(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");
		$tile->rotate();
		$this->assertEquals("cap-s.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("cap-w.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("cap-n.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("cap-e.png", $tile->getId());

		$tile = new Steampunked\SteampunkTile("ninety-es.png");
		$tile->rotate();
		$this->assertEquals("ninety-sw.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("ninety-wn.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("ninety-ne.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("ninety-es.png", $tile->getId());

		$tile = new Steampunked\SteampunkTile("straight-h.png");
		$tile->rotate();
		$this->assertEquals("straight-v.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("straight-h.png", $tile->getId());

		$tile = new Steampunked\SteampunkTile("tee-esw.png");
		$tile->rotate();
		$this->assertEquals("tee-swn.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("tee-wne.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("tee-nes.png", $tile->getId());
		$tile->rotate();
		$this->assertEquals("tee-esw.png", $tile->getId());
	}
	public function test_owner(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");
		$tile->setOwner(1);

		$this->assertEquals(1, $tile->getOwner());
	}
	public function test_close(){
		$tile = new Steampunked\SteampunkTile("cap-e.png");
		$tile->close("E");

		$this->assertEquals(false, $tile->open()["E"]);
	}
}

/// @endcond
?>
