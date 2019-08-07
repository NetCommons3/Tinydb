<?php
/**
 * TinydbFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * TinydbFrameSettings Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Controller
 */
class TinydbFrameSettingsController extends TinydbAppController {

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
				'edit' => 'page_editable',
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
		'NetCommons.DisplayNumber',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->TinydbFrameSetting->saveTinydbFrameSetting($this->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl(true));
			} else {
				return $this->throwBadRequest();
			}

		} else {
			$this->request->data = $this->TinydbFrameSetting->getTinydbFrameSetting();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
