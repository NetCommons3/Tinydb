<?php
/**
 * TinydbApp
 */
App::uses('AppController', 'Controller');
require_once dirname(__DIR__) . '/Lib/TinydbFunctions.php';
/**
 * Class TinydbAppController
 *
 * @property Tinydb $Tinydb
 * @property TinydbFrameSetting $TinydbFrameSetting
 * @property TinydbSetting $TinydbSetting
 * @property Block $Block
 */
class TinydbAppController extends AppController {

/**
 * @var array ブログ名
 */
	protected $_tinydbTitle;

/**
 * @var array ブログ設定
 */
	protected $_tinydbSetting;

/**
 * @var array フレーム設定
 */
	protected $_frameSetting;

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		//'NetCommons.NetCommonsBlock',
		//'NetCommons.NetCommonsFrame',
		'Pages.PageLayout',
		'Security',
	);

/**
 * @var array use model
 */
	public $uses = array(
		'Tinydb.Tinydb',
		'Tinydb.TinydbSetting',
		'Tinydb.TinydbFrameSetting'
	);

	public function beforeFilter() {
		parent::beforeFilter();

		// CurrentDbType初期化
		\Edumap\Tinydb\Lib\CurrentDbType::initByFrame(
			Current::read('Frame')
		);
		$this->viewClass = 'Tinydb.Tinydb';

	}

	/**
 * ブロック名をブログタイトルとしてセットする
 *
 * @return void
 */
	protected function _setupTinydbTitle() {
		$this->loadModel('Blocks.Block');
		$block = $this->Block->find('first', array(
			'recursive' => 0,
			'fields' => ['BlocksLanguage.name'],
			'conditions' => array(
				'Block.id' => Current::read('Block.id')
			)
		));
		$this->_tinydbTitle = isset($block['BlocksLanguage']['name'])
			? $block['BlocksLanguage']['name']
			: '';
	}

/**
 * フレーム設定を読みこむ
 *
 * @return void
 */
	protected function _loadFrameSetting() {
		$this->_frameSetting = $this->TinydbFrameSetting->getTinydbFrameSetting();
	}

/**
 * 設定等の呼び出し
 *
 * @return void
 */
	protected function _prepare() {
		$this->_setupTinydbTitle();
		$this->_initTinydb(['tinydbSetting']);
		$this->_loadFrameSetting();
	}

/**
 * initTinydb
 *
 * @param array $contains Optional result sets
 * @return bool True on success, False on failure
 */
	protected function _initTinydb($contains = []) {
		$tinydb = $this->Tinydb->getTinydb();
		if (! $tinydb) {
			return $this->throwBadRequest();
		}
		$this->_tinydbTitle = $tinydb['Tinydb']['name'];
		$this->set('tinydb', $tinydb);

		if (! $tinydbSetting = $this->TinydbSetting->getTinydbSetting()) {
			$tinydbSetting = $this->TinydbSetting->createBlockSetting();
			$tinydbSetting['TinydbSetting']['tinydb_key'] = null;
		} else {
			$tinydbSetting['TinydbSetting']['tinydb_key'] = $tinydb['Tinydb']['key'];
		}
		$this->_tinydbSetting = $tinydbSetting;
		$this->set('tinydbSetting', $tinydbSetting['TinydbSetting']);

		$this->set('userId', (int)$this->Auth->user('id'));

		return true;
	}

}
