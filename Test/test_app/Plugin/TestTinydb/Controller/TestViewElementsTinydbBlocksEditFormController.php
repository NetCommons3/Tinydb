<?php
/**
 * View/Elements/TinydbBlocks/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/TinydbBlocks/edit_formテスト用Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\test_app\Plugin\TestTinydb\Controller
 */
class TestViewElementsTinydbBlocksEditFormController extends AppController {

/**
 * @var array helpers
 */
	public $helpers = [
		'Likes.Like',
	];

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;

		$this->request->data = [
			'Frame' => [
				'id' => 1
			],
			'Block' => [
				'id' => 2,
				'key' => 'content_block_key_2',
				'language_id' => 2,
				'room_id' => '4',
				'plugin_key' => 'tinydb',
				'public_type' => 2,
				'publish_start' => null,
				'publish_end' => null,
			],
			'Tinydb' => [
				'id' => 4,
				'key' => 'tinydb_key_4',
				'name' => 'TinydbTitle',
			],
			'TinydbSetting' => [
				'use_workflow' => 1,
				'use_sns' => 1,
				'use_comment' => 1,
			],
			'TinydbFrameSetting' => [
				'id' => 6,
				'frame_key' => 'frame_key_1',
				'articles_per_page' => 10,
			],
		];
	}

}
