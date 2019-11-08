<?php
/**
 * EventManagerTest
 */

namespace NetCommons\Tinydb\TestCase\Lib;

use NetCommons\Tinydb\Lib\CurrentDbType;
use NetCommons\Tinydb\Lib\EventManager;

/**
 * Class EventManagerTest
 *
 * @package NetCommons\Tinydb\TestCase\Lib
 */
class EventManagerTest extends \CakeTestCase {

/**
 * testDispatch
 *
 * @return void
 */
	public function testDispatch() {
		$eventManager = EventManager::instance();
		$eventManager->attach('Test', function (&$first, &$second) {
			$first = 1;
			$second = 2;
		});

		$first = '1st';
		$second = '2nd';
		$eventManager->dispatch('Test', $first, $second);

		$this->assertSame(1, $first);
		$this->assertSame(2, $second);
	}
}
