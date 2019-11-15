<?php
/**
 * Tinydb::createTinydb()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Tinydb::createTinydb()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\Tinydb
 */
class TinydbCreateTinydbTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tinydb.tinydb',
		'plugin.tinydb.tinydb_item',
		'plugin.tinydb.tinydb_frame_setting',
		'plugin.tinydb.block_setting_for_tinydb',
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.categories.categories_language',
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'tinydb';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Tinydb';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'createTinydb';

/**
 * @var array Current::$current待避
 */
	protected $_current = array();

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_current = Current::$current;
		Current::$current['Room']['id'] = 1;
		Current::$current['language']['id'] = 2;
	}

/**
 * teadDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Current::$current = $this->_current;
	}

/**
 * createTinydb()のテスト
 *
 * @return void
 */
	public function testCreateTinydb() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		// ブログ名に New tinydbが含まれる
		//$this->assertContains('New tinydb', $result['Tinydb']['name']);
		// TinydbSettingがある
		$this->assertArrayHasKey('TinydbSetting', $result);
		// Blockにroom_idがセットされてる
		$this->assertEquals(1, $result['Block']['room_id']);
	}

}
