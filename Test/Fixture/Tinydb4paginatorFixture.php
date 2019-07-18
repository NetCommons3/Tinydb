<?php
/**
 * TinydbFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbFixture', 'Tinydb.Test/Fixture');

/**
 * TinydbFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Test\Fixture
 * @codeCoverageIgnore
 */
class Tinydb4paginatorFixture extends TinydbFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Tinydb';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//Tinydb 1
		array(
			'id' => '1',
			'block_id' => '1',
			'key' => 'Tinydb_1',
			'name' => 'Tinydb name 1',
			//'language_id' => '1',
		),
		array(
			'id' => '2',
			'block_id' => '2',
			'key' => 'Tinydb_1',
			'name' => 'Tinydb name 1',
			//'language_id' => '2',
		),
		//Tinydb 2
		array(
			'id' => '3',
			'block_id' => '4',
			'key' => 'Tinydb_2',
			'name' => 'Tinydb name 2',
			//'language_id' => '2',
		),
		//Tinydb 3
		array(
			'id' => '4',
			'block_id' => '6',
			'key' => 'Tinydb_3',
			'name' => 'Tinydb name 2',
			//'language_id' => '2',
		),

		//101-200まで、ページ遷移のためのテスト
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		for ($i = 101; $i <= 200; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'block_id' => $i,
				'key' => 'Tinydb_' . $i,
				'name' => 'Tinydb_name_' . $i,
				//'language_id' => '2',
			);
		}
		parent::init();
	}

}
