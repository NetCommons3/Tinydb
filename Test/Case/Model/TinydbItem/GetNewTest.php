<?php
/**
 * TinydbItem::getNew()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('WorkflowGetTest', 'Workflow.TestSuite');

/**
 * TinydbItem::getNew()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbItem
 */
class TinydbItemGetNewTest extends WorkflowGetTest {

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
	protected $_modelName = 'TinydbItem';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getNew';

/**
 * getNew()のテスト
 *
 * @return void
 */
	public function testGetNew() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		// NetCommonsTimeに現在日付を 2016-01-01 00:00:00 に設定する
		$nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
		$nowProperty->setAccessible(true);
		$nowProperty->setValue(strtotime('2016-01-01 00:00:00'));
		// test code ..

		//テスト実施
		$result = $this->$model->$methodName();

		$this->assertEquals('2016-01-01 00:00:00', $result['TinydbItem']['publish_start']);

		$nowProperty->setValue(null); // 現在日時変更が他のテストに影響を与えないようにnullにもどしておく
	}
}
