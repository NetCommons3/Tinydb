<?php
/**
 * View/Elements/entry_meta_infoのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/entry_meta_infoのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\EntryMetaInfo
 */
class TinydbViewElementsEntryMetaInfoTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'plugin.users.user',
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
		$this->generateNc('TestTinydb.TestViewElementsEntryMetaInfo');
	}

/**
 * View/Elements/entry_meta_infoのテスト
 *
 * @return void
 */
	public function testEntryMetaInfo() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_entry_meta_info/entry_meta_info',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/entry_meta_info', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// 掲載日時
		$this->assertContains(
			__d('tinydb', 'posted : %s', $this->controller->View->Date->dateFormat('2016-01-01 00:00:00')),
			$this->view
		);
		// 投稿者リンク
		$this->assertContains('ng-controller="Users.controller', $this->view);
		// カテゴリリンク
		$this->assertRegExp('/<a.*?href=".*?category_id:1.*?">Category Name<\/a>/', $this->view);
	}

}