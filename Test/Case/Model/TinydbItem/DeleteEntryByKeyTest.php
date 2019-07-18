<?php
/**
 * TinydbItem::deleteEntryByKey()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowDeleteTest', 'Workflow.TestSuite');
App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TinydbItemFixture', 'Tinydb.Test/Fixture');

/**
 * TinydbItem::deleteEntryByKey()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbItem
 */
class TinydbItemDeleteEntryByKeyTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'deleteEntryByKey';

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_removeBehaviors($this->TinydbItem);
	}

/**
 * テストの邪魔になるビヘイビアとアソシエーションをひっぺがす
 *
 * @param TinydbItem $model TinydbItemモデル
 * @return void
 */
	protected function _removeBehaviors($model) {
		$model->Behaviors->unload('Tag');
		$model->Behaviors->unload('ContentComment');
		$model->Behaviors->unload('Like');
		$model->unbindModel(['belongsTo' => ['Like', 'LikesUser']], false);
	}

/**
 * testDeleteEntryByKey
 *
 * @return void
 */
	public function testDeleteEntryByKey() {
		$key = 'content_key_1';
		$result = $this->TinydbItem->deleteEntryByKey($key);
		$this->assertTrue($result);

		$count = $this->TinydbItem->find('count', ['conditions' => ['key' => $key]]);

		$this->assertEquals(0, $count);
	}

/**
 * testDeleteEntryByKey delete failed
 *
 * @return void
 */
	public function testDeleteEntryByKeyFailed() {
		$key = 'content_key_1';
		$tinydbEntryMock = $this->getMockForModel('Tinydb.TinydbItem', ['deleteAll']);
		$tinydbEntryMock->expects($this->once())
			->method('deleteAll')
			->will($this->returnValue(false));

		$this->_removeBehaviors($tinydbEntryMock);

		$this->setExpectedException('InternalErrorException');
		$tinydbEntryMock->deleteEntryByKey($key);
	}

}
