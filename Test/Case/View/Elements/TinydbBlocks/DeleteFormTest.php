<?php
/**
 * View/Elements/TinydbBlocks/delete_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/TinydbBlocks/delete_formのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\TinydbBlocks\DeleteForm
 */
class TinydbViewElementsTinydbBlocksDeleteFormTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
		$this->generateNc('TestTinydb.TestViewElementsTinydbBlocksDeleteForm');
	}

/**
 * View/Elements/TinydbBlocks/delete_formのテスト
 *
 * @return void
 */
	public function testDeleteForm() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_tinydb_blocks_delete_form/delete_form/2/?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/TinydbBlocks/delete_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains(sprintf(__tinydbd('net_commons', 'Delete all data associated with the %s.'), __tinydbd('tinydb', 'Tinydb')), $this->view);

		$this->assertInput('input', 'data[Block][id]', 10, $this->view);
		$this->assertInput('input', 'data[Block][key]', 'block_key_10', $this->view);
		$this->assertInput('input', 'data[Tinydb][key]', 'tinydb_key_10', $this->view);
	}

}
