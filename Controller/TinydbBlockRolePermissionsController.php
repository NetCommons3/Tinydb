<?php
/**
 * BlockRolePermissions Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * BlockRolePermissions Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Controller
 */
abstract class TinydbBlockRolePermissionsController extends TinydbAppController {

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
		'Tinydb.Tinydb',
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
				'edit' => 'block_permission_editable',
			),
		),
		'Tinydb.TinydbBlockTabSetting',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockRolePermissionForm',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$tinydb = $this->Tinydb->getTinydb();
		if (! $tinydb) {
			return $this->throwBadRequest();
		}

		$permissions = $this->Workflow->getBlockRolePermissions(
			array(
				'content_creatable',
				'content_publishable',
				'content_comment_creatable',
				'content_comment_publishable'
			)
		);
		$this->set('roles', $permissions['Roles']);

		if ($this->request->is('post')) {
			if ($this->TinydbSetting->saveTinydbSetting($this->request->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->TinydbSetting->validationErrors);
			$this->request->data['BlockRolePermission'] = Hash::merge(
				$permissions['BlockRolePermissions'],
				$this->request->data['BlockRolePermission']
			);

		} else {
			$this->request->data['TinydbSetting'] = $tinydb['TinydbSetting'];
			$this->request->data['Block'] = $tinydb['Block'];
			$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
