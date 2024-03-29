<?php
/**
 * View/Elements/TinydbItems/edit_linkテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('TinydbItemFixture', 'Tinydb.Test/Fixture');
/**
 * View/Elements/TinydbItems/edit_linkテスト用Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\test_app\Plugin\TestTinydb\Controller
 */
class TestViewElementsTinydbItemsEditLinkController extends AppController {

/**
 * @var array Helpers
 */
	public $helpers = [
		'Workflow.Workflow',
	];

/**
 * edit_link
 *
 * @return void
 */
	public function edit_link() {
		$this->autoRender = true;

		$tinydbItem['TinydbItem'] = (new TinydbItemFixture())->records[0];
		$this->set('tinydbItem', $tinydbItem);
	}

}
