<?php
/**
 * TinydbItem::yetPublish()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowGetTest', 'Workflow.TestSuite');
App::uses('TinydbItemFixture', 'Tinydb.Test/Fixture');

/**
 * TinydbItem::yetPublish()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbItem
 */
class TinydbItemYetPublishTest extends WorkflowGetTest {

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
		'plugin.tags.tags_content',
		'plugin.tags.tag',
		'plugin.likes.like',
		'plugin.likes.likes_user',
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
	protected $_methodName = 'yetPublish';

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TinydbItem->Behaviors->unload('ContentComment');
	}

/**
 * yetPublish()のテスト
 *
 * @param array $tinydbItem テスト対応の記事
 * @param bool $expected yetPublishの期待値
 * @return void
 * @dataProvider dataProvider4testYetPublish
 */
	public function testYetPublish($tinydbItem, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		//$tinydbItem = null;

		//テスト実施
		$result = $this->$model->$methodName($tinydbItem);

		$this->assertEquals($expected, $result);
	}

/**
 * dataProvider testYetPublish
 *
 * @return array
 */
	public function dataProvider4testYetPublish() {
		$fixture = new TinydbItemFixture();
		$data = [

			[['TinydbItem' => $fixture->records[1]], false], // 一度公開された記事
			[['TinydbItem' => $fixture->records[2]], true], // 一度も公開されたことがない記事
			[['TinydbItem' => $fixture->records[5]], false], // 現在公開されてる記事
		];
		return $data;
	}

}
