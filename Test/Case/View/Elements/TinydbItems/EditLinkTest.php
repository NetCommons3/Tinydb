<?php
/**
 * View/Elements/TinydbItems/edit_linkのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/TinydbItems/edit_linkのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\TinydbItems\EditLink
 */
class TinydbViewElementsTinydbItemsEditLinkTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestTinydb.TestViewElementsTinydbItemsEditLink');
	}

/**
 * View/Elements/TinydbItems/edit_linkのテスト
 *
 * @return void
 */
	public function testEditLink() {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);
		\NetCommons\Tinydb\Lib\CurrentDbType::initByPlugin('test_tinydb');
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_tinydb_items_edit_link/edit_link/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/TinydbItems/edit_link', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// リンクがある
		$this->assertContains('<a', $this->view);
		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * View/Elements/TinydbItems/edit_linkのテスト 権限がないと編集リンクは表示されない
 *
 * @return void
 */
	public function testEditLinkNotView() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_tinydb_items_edit_link/edit_link/2?frame_id=6',
			array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/TinydbItems/edit_link', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// リンクがある
		$this->assertNotContains('<a', $this->view);
	}

}
