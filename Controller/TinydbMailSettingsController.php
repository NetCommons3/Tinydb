<?php
/**
 * メール設定Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MailSettingsController', 'Mails.Controller');

require_once dirname(__DIR__) . '/Lib/TinydbFunctions.php';

/**
 * メール設定Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Controller
 */
abstract class TinydbMailSettingsController extends MailSettingsController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockRolePermissionForm',
		'Mails.MailForm',
	);

/**
 * @var array Components
 */
	public $components = [
		'Tinydb.TinydbBlockTabSetting',
	];

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		// CurrentDbType初期化
		\Edumap\Tinydb\Lib\CurrentDbType::initByPlugin(
			$this->plugin
		);
		$this->viewClass = 'Tinydb.Tinydb';

	}

/**
 * beforeRender
 *
 * - viewPathの置換
 *
 * @return void
 */
	public function beforeRender() {

		// viewPathに含まれるプラグイン名をTinydbに変更
		$this->viewPath = str_replace($this->plugin, 'Tinydb', $this->viewPath);

		parent::beforeRender();
	}
}
