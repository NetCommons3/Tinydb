<?php
/**
 * TinydbFrameSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @tinydb http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FrameSettingsControllerTest', 'Frames.TestSuite');

/**
 * TinydbFrameSettingsController::edit()のテスト
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Controller\TinydbFrameSettingsController
 */
class TinydbFrameSettingsControllerEditTest extends FrameSettingsControllerTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tinydb.tinydb',
		'plugin.tinydb.tinydb_frame_setting',
		'plugin.tinydb.block_setting_for_tinydb',
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
	protected $_controller = 'tinydb_frame_settings';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$frameId = '6';
		$frameKey = 'frame_3';
		$tinydbFrameId = '6';

		$data = array(
			'Frame' => array(
				'id' => $frameId,
				'key' => $frameKey,
			),
			'TinydbFrameSetting' => array(
				'id' => $tinydbFrameId,
				'frame_key' => $frameKey,
				'articles_per_page' => '10',
			),
		);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー(省略可)
 *  - exception: Exception Error(省略可)
 *
 * @return array
 */
	public function dataProviderEdit() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'post', 'data' => $data, 'validationError' => false);
		$results[2] = array('method' => 'put', 'data' => $data, 'validationError' => false);
		$results[3] = array('method' => 'put', 'data' => $data,
			'validationError' => array(
				'field' => 'TinydbFrameSetting.frame_key',
				'value' => null,
			),
			'BadRequestException'
		);

		return $results;
	}

}
