<?php
namespace Edumap\Tinydb\TestCase\Lib;

use Edumap\Tinydb\Lib\CurrentDbType;

class CurrentDbTypeTest extends \CakeTestCase {
	public function testInit() {
		$frame = [
			'Frame' => [
				'default_setting_action' => 'tinydb_blocks/index/db_type:attendance'
			]
		];
		$currentDbType = CurrentDbType::initByFrame($frame);

		$this->assertInstanceOf(CurrentDbType::class, $currentDbType);
	}

	/**
	 * testDbType
	 *
	 * @param array $frame
	 * @return void
	 * @dataProvider data4testGetDbType
	 */
	public function testGetDbType(string $expectedDbType, array $frame) {
		$currentDbType = CurrentDbType::initByFrame($frame);

		$this->assertSame($expectedDbType, $currentDbType->getDbType());
	}

	public function data4testGetDbType() {
		return [
			[
				'expectedDbType' => 'attendance',
				'frame' => [
					'Frame' => [
						'default_setting_action' => 'tinydb_blocks/index/db_type:attendance',
					]
				]
			],
			[
				'expectedDbType' => 'school_lunch',
				'frame' => [
					'Frame' => [
						'default_setting_action' => 'tinydb_blocks/index/db_type:school_lunch',
					]
				]
			],
		];
	}

	public function testInstance() {
		$frame = [
			'Frame' => [
				'default_setting_action' => 'tinydb_blocks/index/db_type:attendance'
			]
		];
		$currentDbType = CurrentDbType::initByFrame($frame);

		$currentDbType2 = CurrentDbType::instance();

		$this->assertSame($currentDbType, $currentDbType2);
	}
}
