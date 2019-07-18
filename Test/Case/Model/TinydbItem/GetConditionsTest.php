<?php
/**
 * TinydbItem::getConditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowGetTest', 'Workflow.TestSuite');

/**
 * TinydbItem::getConditions()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\Model\TinydbItem
 */
class TinydbItemGetConditionsTest extends WorkflowGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tinydb.tinydb',
		'plugin.tinydb.tinydb_item',
		'plugin.tinydb.tinydb_frame_setting',
		'plugin.tinydb.block_setting_for_tinydb',
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.categories.categories_language',
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'tinydb';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'TinydbItem';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getConditions';

/**
 * test getConditions content_readable = false
 *
 * @return void
 */
	public function testGetConditionsForNotReadable() {
		$permissions = [
			'content_readable' => false,
		];
		$result = $this->TinydbItem->getConditions(1, $permissions);
		$this->assertEquals(['TinydbItem.id' => 0], $result);
	}

/**
 * test getConditions content_readable = true
 *
 * @return void
 */
	public function testGetConditionsForReadable() {
		$permissions = [
			'content_readable' => true,
		];
		$blockId = 1;
		$result = $this->TinydbItem->getConditions($blockId, $permissions);
		$this->assertEquals($blockId, $result['TinydbItem.block_id']);
	}
}
