<?php
/**
 * View/Elements/item_meta_infoテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/item_meta_infoテスト用Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\test_app\Plugin\TestTinydb\Controller
 */
class TestViewElementsItemMetaInfoController extends AppController {

/**
 * item_meta_info
 *
 * @return void
 */
	public function item_meta_info() {
		$this->autoRender = true;
		$tinydbItem = [
			'TinydbItem' => [
				'key' => 'content_key_1',
				'status' => WorkflowComponent::STATUS_PUBLISHED,
				'publish_start' => '2016-01-01 00:00:00',
				'category_id' => 1,
				'created_user' => 1,
			],
			'TrackableCreator' => [
				'id' => 1,
				'handlename' => 'admin'
			],
			'CategoriesLanguage' => [
				'name' => 'Category Name'
			],
		];
		$this->set('tinydbItem', $tinydbItem);
	}

}
