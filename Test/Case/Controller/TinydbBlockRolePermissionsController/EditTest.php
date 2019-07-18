<?php
/**
 * TinydbBlockRolePermissionsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermissionsControllerEditTest', 'Blocks.TestSuite');

/**
 * TinydbBlockRolePermissionsController::edit()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Controller\TinydbBlockRolePermissionsController
 */
class TinydbBlockRolePermissionsControllerEditTest extends BlockRolePermissionsControllerEditTest {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'tinydb_block_role_permissions';

/**
 * 権限設定で使用するFieldsの取得
 *
 * @return array
 */
	private function __approvalFields() {
		$data = array(
			'TinydbSetting' => array(
				'use_workflow',
				'use_comment_approval',
				'approval_type',
			)
		);

		return $data;
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$data = array(
			'TinydbSetting' => array(
				'id' => 2,
				'tinydb_key' => 'tinydb_key_2',
				'use_workflow' => true,
				'use_comment_approval' => true,
				'approval_type' => true,
			)
		);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - approvalFields コンテンツ承認の利用有無のフィールド
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditGet() {
		return array(
			array('approvalFields' => $this->__approvalFields()),
		);
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - data POSTデータ
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditPost() {
		return array(
			array('data' => $this->__data())
		);
	}

/**
 * editアクションのGETテスト(Exceptionエラー)
 *
 * @param array $approvalFields コンテンツ承認の利用有無のフィールド
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testEditGetExceptionError($approvalFields, $exception = null, $return = 'view') {
		$this->_mockForReturnFalse('Tinydb.Tinydb', 'getTinydb');

		$exception = 'BadRequestException';
		$this->testEditGet($approvalFields, $exception, $return);
	}

/**
 * test Post でのsaveTinydbSetting 失敗
 *
 * @param array $data saveデータ
 * @return void
 * @dataProvider dataProviderEditPost
 */
	public function testSaveTinydbSettingFail($data) {
		$this->_mockForReturnFalse('Tinydb.TinydbSetting', 'saveTinydbSetting');

		//$this->_controller->NetCommons = $this->getMock('NetCommonsComponent', ['handleValidationError']);
		//
		//$this->_controller->NetCommons->expects($this->once())
		//	->method('handleValidationError');

		$result = $this->testEditPost($data, false, 'view');
		$approvalFields = $this->__approvalFields();
		$this->_assertEditGetPermission($approvalFields, $result);
	}
}
