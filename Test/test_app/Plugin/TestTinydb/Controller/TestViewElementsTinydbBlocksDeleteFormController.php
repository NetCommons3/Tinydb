<?php
/**
 * View/Elements/TinydbBlocks/delete_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/TinydbBlocks/delete_formテスト用Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\test_app\Plugin\TestTinydb\Controller
 */
class TestViewElementsTinydbBlocksDeleteFormController extends AppController {

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$block = [
			'id' => 10,
			'key' => 'block_key_10'
		];
		$this->set('block', $block);
		$tinydb = [
			'key' => 'tinydb_key_10'
		];
		$this->set('tinydb', $tinydb);
		$this->autoRender = true;
	}

}
