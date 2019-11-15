<?php
/**
 * TinydbItem::saveItem()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('WorkflowSaveTest', 'Workflow.TestSuite');
App::uses('TinydbItemFixture', 'Tinydb.Test/Fixture');

/**
 * TinydbItem::saveItem()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbItem
 */
class TinydbItemSaveItemTest extends WorkflowSaveTest {

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
		//'plugin.content_comments.content_comment',
		//'plugin.mails.mail_setting',
		//'plugin.mails.mail_queue',
		//'plugin.mails.mail_queue_user',
		//'plugin.site_manager.site_setting',
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
	protected $_methodName = 'saveItem';

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TinydbItem->Behaviors->unload('ContentComment');
		$this->TinydbItem->Behaviors->unload('Topics');
	}

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['TinydbItem'] = (new TinydbItemFixture())->records[1];
		$data['TinydbItem']['status'] = '1';

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.TinydbItem.id', null);
		$results[1] = Hash::insert($results[1], '0.TinydbItem.key', null);
		$results[1] = Hash::remove($results[1], '0.TinydbItem.created_user');
		$results[1] = Hash::remove($results[1], '0.TinydbItem.created');

		return $results;
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Tinydb.TinydbItem', 'save'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Tinydb.TinydbItem'),
		);
	}

}
