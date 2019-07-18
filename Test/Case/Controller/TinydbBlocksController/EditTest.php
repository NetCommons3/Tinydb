<?php
/**
 * TinydbBlocksController::add(),edit(),delete()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerEditTest', 'Blocks.TestSuite');

/**
 * TinydbBlocksController::add(),edit(),delete()
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Controller\TinydbBlocksController
 */
class TinydbBlocksControllerEditTest extends BlocksControllerEditTest {

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
	protected $_controller = 'tinydb_blocks';

/**
 * Edit controller name
 *
 * @var string
 */
	protected $_editController = 'tinydb_blocks';

/**
 * テストDataの取得
 *
 * @param bool $isEdit 編集かどうか
 * @return array
 */
	private function __data($isEdit) {
		$frameId = '6';
		//$frameKey = 'frame_3';
		if ($isEdit) {
			$blockId = '4';
			$blockKey = 'block_2';
			$tinydbId = '3';
			$tinydbKey = 'tinydb_key_2';
		} else {
			$blockId = null;
			$blockKey = null;
			$tinydbId = null;
			$tinydbKey = null;
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
				'from' => null,
				'to' => null,
			),
			// 必要のデータセットをここに書く
			'Tinydb' => array(
				'id' => $tinydbId,
				'key' => $tinydbKey,
				'block_id' => $blockId,
				'name' => 'Tinydb name',
			),
		);

		return $data;
	}

/**
 * add()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderAdd() {
		$data = $this->__data(false);

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'put');
		$results[2] = array('method' => 'post', 'data' => $data, 'validationError' => false);
		$results[3] = array('method' => 'post', 'data' => $data,
			'validationError' => array(
				'field' => 'Tinydb.name', //エラーにするフィールド指定
				'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('tinydb', 'Tinydb name')),
			)
		);

		return $results;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderEdit() {
		$data = $this->__data(true);

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'post');
		$results[2] = array('method' => 'put', 'data' => $data, 'validationError' => false);
		$results[3] = array('method' => 'put', 'data' => $data,
			'validationError' => array(
				'field' => 'Tinydb.name', //エラーにするフィールド指定
				'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('tinydb', 'Tinydb name')),
			)
		);

		return $results;
	}

/**
 * delete()アクションDataProvider
 *
 * ### 戻り値
 *  - data 削除データ
 *
 * @return array
 */
	public function dataProviderDelete() {
		$data = array(
			'Block' => array(
				'id' => '4',
				'key' => 'block_2',
			),
			// 必要に応じてパラメータ変更する
			'Tinydb' => array(
				'key' => 'content_block_2',
			),
		);

		//テストデータ
		$results = array();
		$results[0] = array('data' => $data);

		return $results;
	}

/**
 * TinydbNotFoundでBadRequest
 *
 * @return void
 */
	public function testEditTinydbNotFound() {
		//ログイン
		TestAuthGeneral::login($this);

		$this->_mockForReturnFalse('Tinydb.Tinydb', 'getTinydb', 1);

		// Tinydb::getTinydb()がfalseならBadRequest
		//$this->setExpectedException('BadRequestException');

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => '2', 'frame_id' => '6'),
			false, 'BadRequestException', 'view');

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
