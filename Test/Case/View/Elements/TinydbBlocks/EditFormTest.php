<?php
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';
/**
 * View/Elements/TinydbBlocks/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/TinydbBlocks/edit_formのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\TinydbBlocks\EditForm
 */
class TinydbViewElementsTinydbBlocksEditFormTest extends NetCommonsControllerTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Tinydb', 'TestTinydb');
		//テストコントローラ生成
		$this->generateNc('TestTinydb.TestViewElementsTinydbBlocksEditForm');
	}

/**
 * View/Elements/TinydbBlocks/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_tinydb_blocks_edit_form/edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/TinydbBlocks/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//debug($this->view);

		$this->assertInput(
			'input',
			'data[Block][id]',
			$this->controller->request->data['Block']['id'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[Block][key]',
			$this->controller->request->data['Block']['key'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbFrameSetting][frame_key]',
			$this->controller->request->data['TinydbFrameSetting']['frame_key'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbFrameSetting][articles_per_page]',
			$this->controller->request->data['TinydbFrameSetting']['articles_per_page'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[Tinydb][name]',
			$this->controller->request->data['Tinydb']['name'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbSetting][use_workflow]',
			$this->controller->request->data['TinydbSetting']['use_workflow'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbSetting][use_comment]',
			$this->controller->request->data['TinydbSetting']['use_comment'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbSetting][use_sns]',
			$this->controller->request->data['TinydbSetting']['use_sns'],
			$this->view
		);
	}

}
