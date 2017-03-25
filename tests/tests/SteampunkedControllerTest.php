<?php
require __DIR__ . "/../../vendor/autoload.php";
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/2/17
 * Time: 下午10:23
 */
class SteampunkedControllerTest extends \PHPUnit_Extensions_Database_TestCase
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

    public function test_construct(){
        $steampunk = new Steampunked\Steampunked();
        $controller = new Steampunked\SteampunkedController($steampunk, array(),self::$site);

        $this->assertInstanceOf('Steampunked\SteampunkedController', $controller);
        $this->assertFalse($controller->isReset());
        $this->assertEquals('game.php', $controller->getPage());
    }

    public function test_rotate(){
        $steampunk = new Steampunked\Steampunked();
        $controller = new Steampunked\SteampunkedController($steampunk, array(),self::$site);
        $this->assertFalse($controller->isReset());
        $this->assertEquals('game.php', $controller->getPage());
    }

    public function test_give_up(){
        $game = new Steampunked\Games(self::$site);
        $game->createGame("p1","p2","6");
        $id = $game->getId()['id'];
        $game->setTurn($id,"1");

        $steampunk = new Steampunked\Steampunked();
        $steampunk->setSize(6);
        $steampunk->setId($id);
        $steampunk->setPlayerNum(1);

        $controller = new Steampunked\SteampunkedController($steampunk, array(),self::$site);
        $controller->give_up(self::$site);
        $this->assertFalse($controller->isReset());
        $this->assertEquals(2, $steampunk->getWinner());
        $this->assertEquals('win.php', $controller->getPage());
        $game->clear($id);
    }

    public function test_discard(){
        $game = new Steampunked\Games(self::$site);
        $game->createGame("p1","p2","6");
        $id = $game->getId()['id'];
        $game->setTurn($id,"1");

        $steampunk = new \Steampunked\Steampunked(1);
        $steampunk->setSize(6);
        $steampunk->setId($id);
        $steampunk->setPlayerNum(1);
        $pipe1 = $steampunk->getPlayer()->getPipes(1);

        $controller = new Steampunked\SteampunkedController($steampunk, array(),self::$site);
        $controller->discard(0,self::$site);
        $controller->discard(0,self::$site);
        $controller->discard(0,self::$site);
        $this->assertEquals(2, $steampunk->getPlayer()->getPlayerTurn());

        $steampunk->switchPlayer();
        $pipe2 = $steampunk->getPlayer()->getPipes(1);
        $this->assertNotEquals($pipe1[0]->getId(), $pipe2[0]->getId());
        $this->assertEquals($pipe1[1]->getId(), $pipe2[1]->getId());
        $this->assertEquals($pipe1[2]->getId(), $pipe2[2]->getId());
        $this->assertEquals($pipe1[3]->getId(), $pipe2[3]->getId());
        $this->assertEquals($pipe1[4]->getId(), $pipe2[4]->getId());
        $game->clear($id);
    }

    public function test_open_valve(){
        $steampunk = new Steampunked\Steampunked();
        $game = new Steampunked\Games(self::$site);
        $game->createGame("p1","p2","6");
        $id = $game->getId()['id'];
        $game->setTurn($id,"1");
        $steampunk->setSize(6);
        $steampunk->setId($id);

        $controller = new Steampunked\SteampunkedController($steampunk, array(),self::$site);
        $controller->open_valve(1,self::$site);
        $this->assertFalse($controller->isReset());
        $this->assertEquals(2, $steampunk->getWinner());
        $this->assertEquals('win.php', $controller->getPage());
        $game->clear($id);
    }
}

/// @endcond
?>