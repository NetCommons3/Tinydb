<?php
/**
 * TinydbFrameSetting::getTinydbFrameSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * TinydbFrameSetting::getTinydbFrameSetting()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbFrameSetting
 */
class TinydbFrameSettingGetTinydbFrameSettingTest extends NetCommonsGetTest {

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
	protected $_modelName = 'TinydbFrameSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getTinydbFrameSetting';

/**
 * getTinydbFrameSetting()のテスト
 * FrameSettingが存在するFrame.key
 *
 * @return void
 */
	public function testGetTinydbFrameSettingFount() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current['Frame']['key'] = 'frame_key_1';

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$frameKey1Data['TinydbFrameSetting'] = (new TinydbFrameSettingFixture())->records[0];
		$this->assertEquals($frameKey1Data, $result);
		$this->assertArrayHasKey('id', $result['TinydbFrameSetting']);
	}

/**
 * getTinydbFrameSetting()のテスト
 * FrameSettingが存在しないFrame.key
 *
 * @return void
 */
	public function testGetTinydbFrameSettingNotFound() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current['Frame']['key'] = 'frame_key_not_found';

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$this->assertArrayNotHasKey('id', $result['TinydbFrameSetting']);
		$this->assertEquals('frame_key_not_found', $result['TinydbFrameSetting']['frame_key']);
	}

}
