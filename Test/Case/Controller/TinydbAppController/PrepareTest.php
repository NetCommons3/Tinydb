<?php
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';
/**
 * TinydbAppController::initTinydb()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('UserRole', 'UserRoles.Model');

/**
 * TinydbAppController::initTinydb()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Controller\TinydbAppController
 */
class TinydbAppControllerPrepareTest extends NetCommonsControllerTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Tinydb', 'TestTinydb');
		$this->generateNc('TestTinydb.TestTinydbAppControllerIndex');

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * initTinydb()のテスト
 *
 * @return void
 */
	public function testPrepare() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';

		$urlOptions = [
			'plugin' => 'test_tinydb',
			'controller' => 'test_tinydb_app_controller_index',
			'action' => 'index',
			'block_id' => $blockId,
			'frame_id' => $frameId
		];
		//テスト実行
		$this->_testGetAction($urlOptions, ['method' => 'assertNotEmpty']);

		$this->assertEquals('BlockId2Tinydb', $this->vars['tinydb']['Tinydb']['name']);
		$this->assertEquals('content_block_1', $this->vars['tinydbSetting']['tinydb_key']);

		$frameSetting = new ReflectionProperty($this->controller, '_frameSetting');
		$frameSetting->setAccessible(true);
		$value = $frameSetting->getValue($this->controller);
		$this->assertEquals($frameId, $value['TinydbFrameSetting']['id']);
	}

/**
 * tinydbデータが取得できなければBadRequest
 *
 * @return void
 */
	public function testTinydbNotFound() {
		$frameId = null;
		$blockId = '3';

		$urlOptions = [
			'plugin' => 'test_tinydb',
			'controller' => 'test_tinydb_app_controller_index',
			'action' => 'index',
			'block_id' => $blockId,
			'frame_id' => $frameId
		];
		//テスト実行
		$this->_testGetAction($urlOptions, false, 'BadRequestException');
	}

/**
 * 新規ブログ作成時にTinydbSettingが取得できないので、デフォルト値でViewにセット
 *
 * @return void
 */
	public function testTinydbSettingNotFound() {
		$frameId = '6';
		$blockId = '2';

		$urlOptions = [
			'plugin' => 'test_tinydb',
			'controller' => 'test_tinydb_app_controller_index',
			'action' => 'index',
			'block_id' => $blockId,
			'frame_id' => $frameId
		];

		//$this->_mockForReturn('Tinydb.TinydbSetting', 'getTinydbSetting', false, 1);
		$mockModel = 'Tinydb.TinydbSetting';
		$mockMethod = 'getTinydbSetting';
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		$this->controller->$mockModel = $this->getMockForModel(
			$mockPlugin . '.' . $mockModel,
			array($mockMethod),
			array('plugin' => 'Tinydb')
		);

		//テスト実行
		$this->_testGetAction(
			$urlOptions,
			[
				'method' => 'assertNotEmpty'
			]
		);
		$this->assertNull($this->vars['tinydbSetting']['tinydb_key']);
		$this->assertEquals(1, $this->vars['tinydbSetting']['use_sns']);
	}

}
