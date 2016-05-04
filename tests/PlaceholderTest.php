<?php
// run `vendor/phpunit/phpunit/phpunit --verbose tests/PlaceholderTest.php` at the command line

require __DIR__ . '/../vendor/autoload.php';
use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\WebDriverBy;

class PlaceholderTest extends PHPUnit_Framework_TestCase {
  public function testWeBuiltIt() {
    // Given
    $host = 'http://localhost:8000/wd/hub';
    $browser = DesiredCapabilities::phantomjs();
    $browser->setCapability('phantomjs.binary.path', '/usr/bin/phantomjs');
    $driver = RemoteWebDriver::create($host, $browser);
    // uncomment below to launch Firefox instead
    //$driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

    // When: we load the home page
    $driver->get('http://ec2-54-174-113-69.compute-1.amazonaws.com'); // go to the placeholder page

    // Then: test for the headline 'Built it!'
    $actual_text = $driver->findElement(WebDriverBy::cssSelector('h1'))->getText();
    $expected_text = 'Built it!';
    $this->assertEquals(
      $expected_text,
      $actual_text,
      "Current form component is not '$expected_text' but '$actual_text'"
    );

    // Clean up by closing the browser window
    $driver->quit();
  }
}