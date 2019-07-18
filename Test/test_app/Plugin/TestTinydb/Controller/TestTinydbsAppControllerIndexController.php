<?php
/**
 * TinydbAppController::beforeFilter()テスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * TinydbAppController::beforeFilter()テスト用Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\test_app\Plugin\TestTinydb\Controller
 */
class TestTinydbAppControllerIndexController extends TinydbAppController {

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->_prepare();
		$this->autoRender = true;
	}

}
