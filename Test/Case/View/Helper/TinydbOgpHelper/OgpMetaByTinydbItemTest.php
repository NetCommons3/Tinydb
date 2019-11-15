<?php
/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\SnsButtonHelper
 */
class TinydbOgpOgpMetaByTinydbItemTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();
		$params = array(
			'plugin' => 'tinydb',
			'controller' => 'tinydb_items',
			'action' => 'view',
			'key' => 'item_1'
		);
		//Helperロード
		$this->loadHelper('Tinydb.TinydbOgp', $viewVars, $requestData, $params);
	}

/**
 * test no image TinydbItem
 *
 * @throws ReflectionException
 */
	public function testNoImageItem() {
		$tinydbItem = [
			'TinydbItem' => [
				'key' => 'item_1',
				'title' => 'Tinydb item title',
				'body1' => 'Body1 text.'
			]
		];

		$this->TinydbOgp->ogpMetaByTinydbItem($tinydbItem);

		// Viewにアクセスできるようにする
		$property = new ReflectionProperty($this->TinydbOgp, '_View');
		$property->setAccessible(true);
		$view = $property->getValue($this->TinydbOgp);
		$html = $view->fetch('meta');

		$this->assertTextContains('<meta property="og:title" content="Tinydb item title"', $html);
		$this->assertTextContains(
			'<meta property="og:url" content="' . FULL_BASE_URL . '/tinydb/tinydb_items/view/item_1"',
		$html);
		$this->assertTextContains('<meta property="og:description" content="Body1 text."', $html);
		$this->assertTextContains('<meta property="twitter:card" content="summary_large_image"', $html);
	}

}
