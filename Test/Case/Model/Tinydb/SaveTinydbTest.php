<?php
/**
 * Tinydb::saveTinydb()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('TinydbFixture', 'Tinydb.Test/Fixture');

/**
 * Tinydb::saveTinydb()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\Tinydb
 */
class TinydbSaveTinydbTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveTinydb';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['Tinydb'] = (new TinydbFixture())->records[0];

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.Tinydb.id', null);
		$results[1] = Hash::insert($results[1], '0.Tinydb.key', null);
		//$results[1] = Hash::insert($results[1], '0.Tinydb.db_type', '');
		$results[1] = Hash::remove($results[1], '0.Tinydb.created_user');
		$results[1] = Hash::remove($results[1], '0.Tinydb.created');

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
			array($data, 'Tinydb.Tinydb', 'save'),
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
			array($data, 'Tinydb.Tinydb'),
		);
	}

}
