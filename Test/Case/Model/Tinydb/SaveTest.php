<?php
/**
 * Tinydb::beforeSave()とafterSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('TinydbFixture', 'Tinydb.Test/Fixture');

/**
 * Tinydb::beforeSave()とafterSave()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\Tinydb
 */
class TinydbSaveTest extends NetCommonsSaveTest {

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
		'plugin.likes.like',
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
	protected $_methodName = 'saveTinydb';

/**
 * Method name
 *
 * @var string
 */
	public $blockKey = 'block_1';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::write('Plugin.key', $this->plugin);
		Current::write('Block.key', $this->blockKey);
	}

/**
 * テストDataの取得
 *
 * @param string $tinydbKey tinydbのKey
 * @return array
 */
	private function __getData($tinydbKey = 'tinydb_1') {
		$frameId = '6';
		$frameKey = 'frame_3';
		$blockId = '2';
		$blockKey = $this->blockKey;
		if ($tinydbKey === 'tinydb_1') {
			$tinydbId = '2';
		} else {
			$tinydbId = null;
		}

		$data = array(
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '2',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
			),
			'Tinydb' => array(
				'id' => $tinydbId,
				'key' => $tinydbKey,
				'name' => 'tinydbName',
				'block_id' => $blockId,
				'db_type' => '',
				//'bbs_article_count' => '0',
				//'bbs_article_modified' => null,
			),
			'TinydbSetting' => array(
				'use_comment' => '1',
				'use_like' => '1',
				'use_unlike' => '1',
			),
			'TinydbFrameSetting' => array(
				'id' => $tinydbId,
				'frame_key' => $frameKey,
				//'articles_per_page' => 10,
				'articles_per_page' => '10',
				//'comments_per_page' => 10,
			),
		);

		return $data;
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array
 * @see NetCommonsSaveTest::testSave()
 * @see Tinydb::saveTinydb()
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()), //修正
			array($this->__getData(null)), //新規
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 * @see NetCommonsSaveTest::testSaveOnExceptionError()
 * @see Tinydb::saveTinydb()
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Tinydb.Tinydb', 'save'),
			array($this->__getData(null), 'Blocks.BlockSetting', 'saveMany'),
			array($this->__getData(null), 'Tinydb.TinydbFrameSetting', 'save'),
		);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		parent::testSaveOnExceptionError($data, $mockModel, $mockMethod);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return array
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Tinydb.Tinydb'),
			array($this->__getData(), 'Tinydb.TinydbSetting'),
			array($this->__getData(null), 'Tinydb.TinydbFrameSetting'),
		);
	}

}
