<?php
/**
 * TinydbFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for TinydbFixture
 */
class TinydbFixture extends CakeTestFixture {

/**
 * @var string table
 */
	public $table = 'tinydb';

/**
 * Records
 *
 * @see https://github.com/s-nakajima/MyShell/blob/master/unitTest/AboutFixture.md#ブロックidの紐付くfixture
 * @var array
 */
	public $records = array(
		array(
			'id' => 2,
			'block_id' => '2',
			'name' => 'BlockId2Tinydb',
			'db_type' => '',
			'key' => 'content_block_1',
			'created_user' => 1,
			'created' => '2016-03-17 07:09:43',
			'modified_user' => 1,
			'modified' => '2016-03-17 07:09:43'
		),
		array(
			'id' => 4,
			'block_id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'db_type' => '',
			'key' => 'content_block_2',
			'created_user' => 2,
			'created' => '2016-03-17 07:09:43',
			'modified_user' => 2,
			'modified' => '2016-03-17 07:09:43'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Tinydb') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new TinydbSchema())->tables['tinydb'];
		parent::init();
	}

}
