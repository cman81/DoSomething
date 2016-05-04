<?php
require __DIR__ . '/../vendor/autoload.php';
use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\WebDriverBy;

class Sprint1Test extends PHPUnit_Framework_TestCase {
  public function testNavigation() {
    // Given
    $host = 'http://localhost:8000/wd/hub';
    $browser = DesiredCapabilities::phantomjs();
    $browser->setCapability('phantomjs.binary.path', '/usr/bin/phantomjs');
    $driver = RemoteWebDriver::create($host, $browser);

    // When: we go to the home page
    $driver->get('http://ec2-54-174-113-69.compute-1.amazonaws.com'); // go to the home page

    // Then: test for a navigation menu of various options
    $actual_matches = $driver->findElements(WebDriverBy::cssSelector('ul.navigation'));
    $this->assertNotEquals(0, count($actual_matches), 'The home page is expected to have a nav menu, yet it does not');
    // Then: test that we have removed the placeholder text 'Bamboo'
    $is_found_bamboo = strpos(strtolower($driver->getPageSource()), 'bamboo');
    $this->assertFalse($is_found_bamboo, 'We were supposed to have removed the placeholder text for "Bamboo" yet we have not');
    $is_found_github = strpos(strtolower($driver->getPageSource()), 'github');
    $this->assertFalse($is_found_github, 'We were supposed to have removed the placeholder text for "GitHub" yet we have not');

    foreach ($actual_matches as $idx => $nav_item) {
      // When: we click on a navigational item
      $nav_item->click();
      // Then: test that a page actually exists
      $this->assertNotContains('404', $driver->getTitle(), "A page was supposed to exist at navigational link #" . $idx + 1 . " but it did not.");
      // Then: return to the home page (by URL)
      $driver->get('http://ec2-54-174-113-69.compute-1.amazonaws.com');
    }
  }
}