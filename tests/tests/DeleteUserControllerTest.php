<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class DeleteUserControllerTest extends \PHPUnit_Extensions_Database_TestCase
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
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');

        //return $this->createFlatXMLDataSet(dirname(__FILE__) .
        //	'/db/users.xml');
    }
    private static $site;

    public static function setUpBeforeClass()
    {
        self::$site = new Steampunked\Site();
        $localize = require 'localize.inc.php';
        if (is_callable($localize)) {
            $localize(self::$site);
        }
    }
    public function test_construct(){
        $root = self::$site->getRoot();
        $user = new \Steampunked\Users(self::$site);
        $root2 = $root.'?e';
        $controller = new Steampunked\DeleteUserController(self::$site, array(
            'Yes' => 'Yes', 'id'=>'7'
        ));
        $this->assertInstanceOf('Steampunked\DeleteUserController', $controller);
        $this->assertEquals($root.'/users.php', $controller->getRedirect());
        $exist =$user->exists('dudess@dude.com');
        $this->assertFalse($exist);
        $user = new \Steampunked\Users(self::$site);
        $root2 = $root.'?e';
        $controller = new Steampunked\DeleteUserController(self::$site, array(
            'Yes' => 'Yes', 'id'=>'15'
        ));
        $delete = $user->delete(15);
        echo 'THis is delete'.$delete;
        $this->assertInstanceOf('Steampunked\DeleteUserController', $controller);
        $this->assertEquals($root.'/users.php', $controller->getRedirect());
        $user = new \Steampunked\Users(self::$site);
        $root2 = $root.'?e';
        $controller = new Steampunked\DeleteUserController(self::$site, array(
            'Yes' => 'Yes', 'id'=>'0'
        ));
        $this->assertInstanceOf('Steampunked\DeleteUserController', $controller);
        $this->assertEquals($root.'/users.php', $controller->getRedirect());
    }
}

/// @endcond
?>
