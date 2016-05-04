<?php
require __DIR__ . '/../vendor/autoload.php';
use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\WebDriverBy;

class EPALeafletTest extends PHPUnit_Framework_TestCase {
  public function testNavigation() {
    // Given
    $host = 'http://localhost:8000/wd/hub';
    try {
      $browser = DesiredCapabilities::phantomjs();
      $browser->setCapability('phantomjs.binary.path', '/usr/bin/phantomjs');
      $driver = RemoteWebDriver::create($host, $browser);
    } catch (Exception $e) {
      $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());
    }

    // When: we go to the home page
    $driver->get('http://ec2-54-174-84-69.compute-1.amazonaws.com/'); // go to the home page

    // Then: test for the 'Get Started' button
    $actual_button = $driver->findElement(WebDriverBy::cssSelector('div.hero-button'))->getText();
    $is_get_started_found = strpos(strtolower($actual_button), 'get started');
    $this->assertNotFalse($is_get_started_found, "We were supposed to have a 'Get Started' button but we do not.");
  }
}