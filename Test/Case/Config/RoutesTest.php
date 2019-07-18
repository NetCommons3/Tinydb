<?php
/**
 * Config/routes.phpのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsRoutesTestCase', 'NetCommons.TestSuite');

/**
 * Config/routes.phpのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Routing\Route\SlugRoute
 */
class RoutesTest extends NetCommonsRoutesTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'tinydb';

/**
 * DataProvider
 *
 * ### 戻り値
 * - url URL
 * - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array(
				'url' => '/tinydb/tinydb_items/view/1/content_key',
				'expected' => array(
					'plugin' => 'tinydb', 'controller' => 'tinydb_items', 'action' => 'view',
					'block_id' => '1', 'key' => 'content_key',
				)
			),
			array(
				'url' => '/tinydb/tinydb_items_edit/edit/1/content_key',
				'expected' => array(
					'plugin' => 'tinydb', 'controller' => 'tinydb_items_edit', 'action' => 'edit',
					'block_id' => '1', 'key' => 'content_key'
				)
			),
			array(
				'url' => '/tinydb/tinydb_items/tags/2/id:1',
				'expected' => array(
					'plugin' => 'tinydb', 'controller' => 'tinydb_items', 'action' => 'tags',
					'block_id' => '2', 'named' => ['id' => '1'],
				)
			),
			array(
				'url' => '/tinydb/tinydb_items/year_month/2/year_month:2015-01',
				'expected' => array(
					'plugin' => 'tinydb', 'controller' => 'tinydb_items', 'action' => 'year_month',
					'block_id' => '2', 'named' => ['year_month' => '2015-01'],
				)
			),
		);
	}

}
