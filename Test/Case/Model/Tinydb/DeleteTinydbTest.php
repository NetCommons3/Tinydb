<?php
/**
 * Tinydb::deleteTinydb()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');
App::uses('TinydbFixture', 'Tinydb.Test/Fixture');

/**
 * Tinydb::deleteTinydb()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\Tinydb
 */
class TinydbDeleteTinydbTest extends NetCommonsDeleteTest {

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
	protected $_modelName = 'Tinydb';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'deleteTinydb';

/**
 * Delete用DataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return array テストデータ
 */
	public function dataProviderDelete() {
		$data['Tinydb'] = (new TinydbFixture())->records[0];
		$data['Block']['key'] = 'block_1';
		$association = array();

		$results = array();
		$results[0] = array($data, $association);

		return $results;
	}

/**
 * ExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderDeleteOnExceptionError() {
		$data = $this->dataProviderDelete()[0][0];

		return array(
			array($data, 'Tinydb.Tinydb', 'deleteAll'),
			array($data, 'Tinydb.TinydbItem', 'deleteAll'),
		);
	}

}
