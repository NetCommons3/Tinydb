<?php
/**
 * TinydbItemsEdit
 */
App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * TinydbItemsEdit Controller
 *
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @property NetCommonsWorkflow $NetCommonsWorkflow
 * @property PaginatorComponent $Paginator
 * @property TinydbItem $TinydbItem
 * @property TinydbCategory $TinydbCategory
 * @property NetCommonsComponent $NetCommons
 */
abstract class TinydbItemsEditController extends TinydbAppController {

/**
 * @var array use models
 */
	public $uses = array(
		'Tinydb.TinydbItem',
		'Categories.Category',
		'Workflow.WorkflowComment',
	);

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'add,edit,delete' => 'content_creatable',
			),
		),
		'Workflow.Workflow',

		'Categories.Categories',
		//'Tinydb.TinydbItemPermission',
		'NetCommons.NetCommonsTime',
	);

/**
 * @var array helpers
 */
	public $helpers = array(
		'NetCommons.BackTo',
		'NetCommons.NetCommonsForm',
		'Workflow.Workflow',
		'NetCommons.NetCommonsTime',
		'NetCommons.TitleIcon',
		//'Likes.Like',
	);

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$tinydbItem = $this->TinydbItem->getNew();

		return $this->__add($tinydbItem);
	}

/**
 * この記事を元に追加
 *
 * @return void
 */
	public function add_from_item() {
		$this->set('isEdit', false);
		$key = $this->request->query('from_key');
		//  keyのis_latstを元に編集を開始
		$this->TinydbItem->recursive = 0;
		$tinydbItem = $this->TinydbItem->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				'TinydbItem.key' => $key
			)
		));
		if (empty($tinydbItem)) {
			return $this->throwBadRequest();
		}

		$this->_addFromItem($tinydbItem);
	}

/**
 * 新規追加アクションのメイン
 *
 * @param array $tinydbItem TinydbItemData
 * @return void
 */
	private function __add(array $tinydbItem) {
		$this->set('isEdit', false);
		$this->_prepare();

		$this->set('tinydbItem', $tinydbItem);

		if ($this->request->is('post')) {
			$this->TinydbItem->create();
			$this->request->data['TinydbItem']['tinydb_key'] =
				$this->_tinydbSetting['TinydbSetting']['tinydb_key'];

			// set status
			$status = $this->Workflow->parseStatus();
			$this->request->data['TinydbItem']['status'] = $status;

			// set block_id
			$this->request->data['TinydbItem']['block_id'] = Current::read('Block.id');
			// set language_id
			$this->request->data['TinydbItem']['language_id'] = Current::read('Language.id');
			if (($result = $this->TinydbItem->saveItem($this->request->data))) {
				$url = NetCommonsUrl::actionUrl(
					array(
						'controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items',
						'action' => 'view',
						'block_id' => Current::read('Block.id'),
						'frame_id' => Current::read('Frame.id'),
						'key' => $result['TinydbItem']['key']
					)
				);
				return $this->redirect($url);
			}

			$this->NetCommons->handleValidationError($this->TinydbItem->validationErrors);

		} else {
			$this->request->data = $tinydbItem;
			$this->request->data['Tag'] = array();
		}

		$this->view = 'form';
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		$this->set('isEdit', true);
		//$key = $this->request->params['named']['key'];
		$key = $this->params['key'];

		//  keyのis_latstを元に編集を開始
		$this->TinydbItem->recursive = 0;
		$tinydbItem = $this->TinydbItem->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				'TinydbItem.key' => $key
			)
		));
		if (empty($tinydbItem)) {
			return $this->throwBadRequest();
		}

		if ($this->TinydbItem->canEditWorkflowContent($tinydbItem) === false) {
			return $this->throwBadRequest();
		}
		$this->_prepare();

		if ($this->request->is(array('post', 'put'))) {

			$this->TinydbItem->create();
			$this->request->data['TinydbItem']['tinydb_key'] =
				$this->_tinydbSetting['TinydbSetting']['tinydb_key'];

			// set status
			$status = $this->Workflow->parseStatus();
			$this->request->data['TinydbItem']['status'] = $status;

			// set block_id
			$this->request->data['TinydbItem']['block_id'] = Current::read('Block.id');
			// set language_id
			$this->request->data['TinydbItem']['language_id'] = Current::read('Language.id');

			$data = $this->request->data;

			unset($data['TinydbItem']['id']); // 常に新規保存

			if ($this->TinydbItem->saveItem($data)) {
				$url = NetCommonsUrl::actionUrl(
					array(
						'controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items',
						'action' => 'view',
						'frame_id' => Current::read('Frame.id'),
						'block_id' => Current::read('Block.id'),
						'key' => $data['TinydbItem']['key']
					)
				);

				return $this->redirect($url);
			}

			$this->NetCommons->handleValidationError($this->TinydbItem->validationErrors);

		} else {

			$this->request->data = $tinydbItem;

		}

		$this->set('tinydbItem', $tinydbItem);
		$this->set('isDeletable', $this->TinydbItem->canDeleteWorkflowContent($tinydbItem));

		$comments = $this->TinydbItem->getCommentsByContentKey($tinydbItem['TinydbItem']['key']);
		$this->set('comments', $comments);

		$this->view = 'form';
	}

/**
 * delete method
 *
 * @throws InternalErrorException
 * @return void
 */
	public function delete() {
		$this->request->allowMethod('post', 'delete');

		$key = $this->request->data['TinydbItem']['key'];
		$tinydbItem = $this->TinydbItem->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				'TinydbItem.key' => $key
			)
		));

		// 権限チェック
		if ($this->TinydbItem->canDeleteWorkflowContent($tinydbItem) === false) {
			return $this->throwBadRequest();
		}

		if ($this->TinydbItem->deleteItemByKey($key) === false) {
			throw new InternalErrorException(__tinydbd('net_commons', 'Internal Server Error'));
		}
		return $this->redirect(
			NetCommonsUrl::actionUrl(
				array(
					'controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items',
					'action' => 'index',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => Current::read('Block.id')
				)
			)
		);
	}

	/**
	 * ${CARET}_addFromItem
	 *
	 * @param $tinydbItem
	 * @return void
	 */
	protected function _addFromItem($tinydbItem) : void {
// 初期化したいフィールドはunsetする
		// 新規扱いにするのでidは削除する
		unset($tinydbItem['TinydbItem']['id']);
		unset($tinydbItem['TinydbItem']['key']);
		unset($tinydbItem['TinydbItem']['created']);
		unset($tinydbItem['TinydbItem']['created_user']);
		unset($tinydbItem['TinydbItem']['modified']);
		unset($tinydbItem['TinydbItem']['modified_user']);

		unset($tinydbItem['TinydbItem']['is_latest']);
		unset($tinydbItem['TinydbItem']['is_active']);
		unset($tinydbItem['TinydbItem']['status']);

		unset($tinydbItem['TinydbItem']['publish_start']);

		// 新規デフォルトに 元Itemの値を上書き
		$defaultItem = $this->TinydbItem->getNew();
		$tinydbItem = Hash::merge($defaultItem, $tinydbItem);

		$this->__add($tinydbItem);
	}
}
