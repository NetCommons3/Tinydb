<?php

namespace Edumap\Tinydb\TestCase\Lib;

use Edumap\Tinydb\Lib\CurrentDbType;
use Edumap\Tinydb\Lib\EventManager;

class EventManagerTest extends \CakeTestCase {

	public function testDispatch() {
		$eventManager = EventManager::instance();
		$eventManager->attach('Test', function(&$first, &$second) {
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
