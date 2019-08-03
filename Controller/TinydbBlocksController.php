<?php
/**
 * TinydbBlocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * TinydbBlocks Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Controller
 *
 * @property Tinydb $Tinydb
 */
class TinydbBlocksController extends TinydbAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Tinydb.TinydbFrameSetting',
		'Blocks.Block',
		'Tinydb.TinydbItem',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
			),
		),
		'Paginator',
		'Categories.CategoryEdit',
	);

/**
 * use helpers
 * TODO 別途かきかえ
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array(
				'block_index' => array('url' => array('controller' => 'tinydb_blocks')),
				'frame_settings' => array('url' => array('controller' => 'tinydb_frame_settings')),
			),
			'blockTabs' => array(
				'block_settings' => array('url' => array('controller' => 'tinydb_blocks')),
				'mail_settings',
				'role_permissions' => array('url' => array('controller' => 'tinydb_block_role_permissions')),
			),
		),
		'Blocks.BlockIndex',
		//'Blocks.Block',
		'Likes.Like',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//CategoryEditComponentの削除
		if ($this->params['action'] === 'index') {
			$this->Components->unload('Categories.CategoryEdit');
		}
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$currentDbType = \Edumap\Tinydb\Lib\CurrentDbType::instance();
		if ($currentDbType->isSingleDb()) {
			// シングルDBモード
			// 既にDBがあれば、editへ
			$tinydb = $this->Tinydb->find('first', [
				'conditions' => [
					'Tinydb.db_type' => $currentDbType->getDbTypeKey(),
					'Block.room_id' => Current::read('Room.id')
				],
				'recursive' => 0,
			]);
			if ($tinydb) {
				$this->redirect(
					[
						'controller' => $currentDbType->getDbTypeKey() . '_blocks',
						'action' => 'edit',
						$tinydb['Tinydb']['block_id'],
						'?' => [
							'frame_id' => Current::read('Frame.id')
						]
					]
				);
				return;
			}
			// DBがなければ追加へ
			$this->redirect(
				[
					'controller' => $currentDbType->getDbTypeKey() . '_blocks',
					'action' => 'add',
					'?' => [
						'frame_id' => Current::read('Frame.id')
					]
				]
			);
			return;
		}
		$this->Paginator->settings = array(
			'Tinydb' => $this->Tinydb->getBlockIndexSettings()
		);

		$tinydb = $this->Paginator->paginate('Tinydb');
		if (! $tinydb) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('tinydb', $tinydb);
		$this->request->data['Frame'] = Current::read('Frame');
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			//登録処理
			if ($this->Tinydb->saveTinydb($this->data)) {
				$this->NetCommons->setFlashNotification('保存しました。', ['class' => 'success']);
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Tinydb->validationErrors);

		} else {
			//表示処理(初期データセット)
			$this->request->data = $this->Tinydb->createTinydb();
			$this->request->data += $this->TinydbFrameSetting->getTinydbFrameSetting();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put')) {
			//登録処理
			if ($this->Tinydb->saveTinydb($this->data)) {
				$this->NetCommons->setFlashNotification('保存しました。', ['class' => 'success']);
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Tinydb->validationErrors);

		} else {
			//表示処理(初期データセット)
			if (! $tinydb = $this->Tinydb->getTinydb()) {
				return $this->throwBadRequest();
			}
			$this->request->data += $tinydb;
			$this->request->data += $this->TinydbFrameSetting->getTinydbFrameSetting();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if ($this->request->is('delete')) {
			if ($this->Tinydb->deleteTinydb($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
		}

		return $this->throwBadRequest();
	}
}
