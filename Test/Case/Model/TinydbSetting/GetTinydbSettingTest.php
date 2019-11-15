<?php
/**
 * TinydbSetting::getTinydbSetting()のテスト
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
 * TinydbSetting::getTinydbSetting()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbSetting
 */
class TinydbSettingGetTinydbSettingTest extends NetCommonsGetTest {

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
	protected $_modelName = 'TinydbSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getTinydbSetting';

/**
 * getTinydbSetting()のテスト
 *
 * @return void
 */
	public function testGetTinydbSetting() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::write('Plugin.key', $this->plugin);
		Current::write('Block.key', 'block_1');
		Current::write('Language.id', '2');
		Current::write('Room.need_approval', '1'); //ルーム承認する

		//テスト実施
		$result = $this->$model->$methodName();
		$expects = [
			'TinydbSetting' => [
				'use_workflow' => 1,
				'use_comment' => 1,
				'use_comment_approval' => 1,
				'use_like' => 1,
				'use_unlike' => 1,
				'use_sns' => 1,
			]
		];
		$this->assertEquals($expects, $result);
	}

}
