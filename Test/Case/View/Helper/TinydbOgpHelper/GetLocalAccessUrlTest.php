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
 * ServerSetting.localUrlMap が定義されてたらローカルサーバからアクセス可能なURLに変換するテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\SnsButtonHelper
 */
class TinydbOgpGetlocalAccesUrlTest extends NetCommonsHelperTestCase {

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
			//'plugin' => 'tinydb',
			//'controller' => 'tinydb_items',
			//'action' => 'view',
			//'key' => 'item_1'
		);

		// テスト時のURL変換マップ
		$setting = [
			'localUrlMap' => [
				'http://app.local:9090' => 'http://localhost'
			]
		];
		Configure::write('ServerSetting', $setting);

		//Helperロード
		$this->loadHelper('Tinydb.TinydbOgp', $viewVars, $requestData, $params);
	}

/**
 * Test TinydbOgp::__getLocalAccessUrl()
 *
 * @param string $remoteUrl 変換元URL
 * @param string $localUrl 変換後のURL期待値
 * @throws ReflectionException
 * @return void
 * @dataProvider data4testGetLocalAccessUrl
 */
	public function testConvertFullUrl($remoteUrl, $localUrl) {
		$method = new ReflectionMethod($this->TinydbOgp, '__getLocalAccessUrl');
		$method->setAccessible(true);

		$result = $method->invoke($this->TinydbOgp, $remoteUrl);
		$this->assertEquals($localUrl, $result);
	}

/**
 *  test case
 *
 * @return array
 */
	public function data4testGetLocalAccessUrl() {
		$data = [
			[
				'remoteUrl' => 'http://app.local:9090/test',
				'localUrl' => 'http://localhost/test'
			],
			[
				'remoteUrl' => 'http://example.com/test',
				'localUrl' => 'http://example.com/test'
			],
		];
		return $data;
	}
}
