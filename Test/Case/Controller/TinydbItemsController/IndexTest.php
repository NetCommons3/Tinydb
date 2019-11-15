<?php
/**
 * TinydbItemsController::index()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * require
 */
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('WorkflowControllerIndexTest', 'Workflow.TestSuite');

/**
 * TinydbItemsController::index()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Controller\TinydbItemsController
 */
class TinydbItemsControllerIndexTest extends WorkflowControllerIndexTest {

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
		'plugin.content_comments.content_comment',
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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'tinydb_items';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$frameId = '6';
		$blockId = '2';

		$data = array(
			'action' => 'index',
			'frame_id' => $frameId,
			'block_id' => $blockId,
		);

		return $data;
	}

/**
 * indexアクションのテスト(ログインなし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndex() {
		$data0 = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => $data0,
			'assert' => array('method' => 'assertNotEmpty'),
		);

		// ブロックID取れないとき
		$data1 = $this->__data();
		$data1['block_id'] = 0; // 存在しない
		$data1['frame_id'] = null; // frame_idをセットしちゃうとURLにブロックIDなくてもframe_idからblock_idを特定できちゃうので、null上書きしておく
		$results[1] = array(
			'urlOptions' => $data1,
			'assert' => array('method' => 'assertNull'),
		);

		// カテゴリIDによる絞り込み
		$data2 = $this->__data();
		$data2['category_id'] = 1;

		$results[2] = array(
			'urlOptions' => $data2,
			'assert' => array('method' => 'assertRegExp', 'expected' => '/<h1.*?>' . __tinydbd('tinydb', 'Category') . '/'),
		);

		return $results;
	}

/**
 * indexアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndex
 * @return void
 */
	public function testIndex($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		TestAuthGeneral::logout($this); // webテスト中は管理者ログインしてるとゲスト扱いにならないようなのでログアウトしておく

		parent::testIndex($urlOptions, $assert, $exception, $return);

		// ゲストなら追加ボタンはでない
		$this->assertTextNotContains(__tinydbd('tinydb', 'Add item'), $this->view);
	}

/**
 * indexアクションのテスト(作成権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByCreatable() {
		return array($this->dataProviderIndex()[0]);
	}

/**
 * indexアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByCreatable
 * @return void
 */
	public function testIndexByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testIndexByCreatable($urlOptions, $assert, $exception, $return);

		//チェック
		// 追加ボタンがある
		$this->assertTextContains(__tinydbd('tinydb', 'Add item'), $this->view);
	}

/**
 * indexアクションのテスト(編集権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByEditable() {
		return array($this->dataProviderIndex()[0]);
	}

/**
 * indexアクションのテスト(編集権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByEditable
 * @return void
 */
	public function testIndexByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testIndexByEditable($urlOptions, $assert, $exception, $return);

		//チェック
		// 追加ボタンがある
		$this->assertTextContains(__tinydbd('tinydb', 'Add item'), $this->view);
	}

}
