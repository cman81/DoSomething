<?php
// run `vendor/phpunit/phpunit/phpunit --verbose tests/PlaceholderTest.php` at the command line

require __DIR__ . '/../vendor/autoload.php';
use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\WebDriverBy;

class PlaceholderTest extends PHPUnit_Framework_TestCase {
  public function testWeBuiltIt() {
    // Given
    $host = 'http://localhost:4444/wd/hub'; // this is the default for selenium-server-standalone
    /*    $browser = DesiredCapabilities::phantomjs();
        $browser->setCapability('phantomjs.binary.path', 'c:\Program Files\phantomjs-2.1.1-windows\bin\phantomjs.exe');
        $driver = RemoteWebDriver::create($host, $browser); // launch Firefox*/
    $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

    // When we load the home page
    $driver->get('http://ec2-54-174-113-69.compute-1.amazonaws.com'); // go to the placeholder page
    $actual_text = $driver->findElement(WebDriverBy::cssSelector('h1'))->getText();
    $expected_text = 'Built it!';

    // Test for the headline 'Built it!'
    $this->assertEquals(
      $expected_text,
      $actual_text,
      "Current form component is not '$expected_text' but '$actual_text'"
    );

    // Clean up by closing the browser window
    $driver->quit();
  }
}