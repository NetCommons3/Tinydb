<?php
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';
/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\SnsButtonHelper
 */
class TinydbOgpConvertFullUrlTest extends NetCommonsHelperTestCase {

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

		$stub = $this->getMockBuilder('NetCommonsHtml')
			->setMethods(['url'])
			->getMock();
		$map = [
			['/tinydb/tinydb_items/view/item_1'],
			//[null, [], FULL_BASE_URL . '/tinydb/tinydb_items/view/item_1'],
			['/tinydb/tinydb_items/view/../foo/bar.jpg', true, FULL_BASE_URL . '/tinydb/tinydb_items/view/../foo/bar.jpg']
		];

		$stub->method('url')
			->will($this->returnValueMap($map));
		$this->TinydbOgp->NetCommonsHtml = $stub;
	}

/**
 * Tset TinydbOgp::__convertFullUrl()
 *
 * @param string $imageUrl image url
 * @param string $fullUrl フルURLの期待値
 * @throws ReflectionException
 * @return void
 * @dataProvider data4ConvertFullUrl
 */
	public function testConvertFullUrl($imageUrl, $fullUrl) {
		$method = new ReflectionMethod($this->TinydbOgp, '__convertFullUrl');
		$method->setAccessible(true);

		$result = $method->invoke($this->TinydbOgp, $imageUrl);
		debug($result);
		$this->assertEquals($fullUrl, $result);
	}

/**
 * testConvertFullUrl test case
 *
 * @return array
 */
	public function data4ConvertFullUrl() {
		$data = [
			[
				'imageUrl' => 'http://example.com/foo.jpg',
				'fullUrl' => 'http://example.com/foo.jpg'
			],
			[
				'imageUrl' => '/foo/bar.jpg',
				'fullUrl' => FULL_BASE_URL . '/foo/bar.jpg'
			],
			[
				'imageUrl' => '../foo/bar.jpg',
				'fullUrl' => FULL_BASE_URL . '/tinydb/tinydb_items/view/../foo/bar.jpg'
			],

		];
		return $data;
	}
}
