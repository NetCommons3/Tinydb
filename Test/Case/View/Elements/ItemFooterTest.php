<?php
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';
/**
 * View/Elements/item_footerのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/item_footerのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\ItemFooter
 */
class TinydbViewElementsItemFooterTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		$this->generateNc('TestTinydb.TestViewElementsItemFooter',
			[
				'helpers' => [
					'ContentComments.ContentComment' => array(
						'viewVarsKey' => array(
							'contentKey' => 'tinydbItem.TinydbItem.key',
							'contentTitleForMail' => 'tinydbItem.TinydbItem.title',
							'useComment' => 'tinydbSetting.use_comment',
							'useCommentApproval' => 'tinydbSetting.use_comment_approval'
						)
					),
				]
			]
		);
	}

/**
 * View/Elements/item_footerのテスト
 *
 * @return void
 */
	public function testItemFooter() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_item_footer/item_footer',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/item_footer', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// use sns
		$this->assertNotContains('fb-like', $this->view);
		$this->assertNotContains('twitter.com', $this->view);
		// use like
		$this->assertContains('glyphicon-thumbs-up', $this->view);
		// indexでもLikeボタンを表示
		$this->assertContains('ng-controller="Likes"', $this->view);

		// indexではcontent comment countを表示
		$this->assertContains('tinydb__content-comment-count', $this->view);
	}

/**
 * use_sns falseのテスト
 *
 * @return void
 */
	public function testNotUseSns() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_item_footer/not_use_sns',
			array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/item_footer', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// use sns
		$this->assertNotContains('fb-like', $this->view);
		$this->assertNotContains('twitter.com', $this->view);
		// use like
		$this->assertContains('glyphicon-thumbs-up', $this->view);
		// indexでもLikeボタンを表示
		$this->assertContains('ng-controller="Likes"', $this->view);

		// indexではcontent comment countを表示
		$this->assertContains('tinydb__content-comment-count', $this->view);
	}

/**
 * indexじゃないときのテスト
 *
 * @return void
 */
	public function testNotIndex() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_item_footer/not_index',
			array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/item_footer', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		// use sns

		$this->assertNotContains('fb-like', $this->view);
		$this->assertNotContains('twitter.com', $this->view);
		// use like
		$this->assertContains('glyphicon-thumbs-up', $this->view);
		// index以外でもLikeボタン表示
		$this->assertContains('ng-controller="Likes"', $this->view);

		// indexではcontent comment countを表示
		$this->assertNotContains('tinydb__content-comment-count', $this->view);
	}

}
