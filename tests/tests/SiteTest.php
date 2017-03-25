<?php

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";
class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test_GettersAndSetters() {
		//$this->assertEquals($expected, $actual);
		$site = new Steampunked\Site();
		$site->setEmail("mateen.esfahanian@gmail.com");
		$this->assertEquals("mateen.esfahanian@gmail.com",$site->getEmail());
		$site = new Steampunked\Site();
		$site->setEmail("");
		$this->assertEquals("",$site->getEmail());
		$site = new Steampunked\Site();
		$site->setRoot("User\Mateen");
		$this->assertEquals("User\Mateen",$site->getRoot());
		$site = new Steampunked\Site();
		$this->assertEquals("",$site->getTablePrefix());

	}
	public function test_localize() {
		$site = new Steampunked\Site();
		$localize = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize($site);
		}
		$this->assertEquals('testProj2_', $site->getTablePrefix());
	}
}

/// @endcond
?>
