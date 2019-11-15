<?php
/**
 * View/Elements/TinydbFrameSettings/edit_formのテスト
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
 * View/Elements/TinydbFrameSettings/edit_formのテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\View\Elements\TinydbFrameSettings\EditForm
 */
class TinydbViewElementsTinydbFrameSettingsEditFormTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestTinydb.TestViewElementsTinydbFrameSettingsEditForm');
	}

/**
 * View/Elements/TinydbFrameSettings/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_tinydb/test_view_elements_tinydb_frame_settings_edit_form/edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/TinydbFrameSettings/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput(
			'input',
			'data[Frame][id]',
			$this->controller->request->data['Frame']['id'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[Frame][key]',
			$this->controller->request->data['Frame']['key'],
			$this->view
		);
		$this->assertInput(
			'input',
			'data[TinydbFrameSetting][id]',
			$this->controller->request->data['TinydbFrameSetting']['id'],
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
	}

}
