<?php
/**
 * Tinydb Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TinydbAppModel', 'Tinydb.Model');

/**
 * Tinydb Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Tinydb\Model
 */
class Tinydb extends TinydbAppModel {

/**
 * use tables
 *
 * @var string
 */
	public $useTable = 'tinydb';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'name' => 'Tinydb.name',
			'loadModels' => array(
				'Like' => 'Likes.Like',
				'BlockSetting' => 'Blocks.BlockSetting',
				'Category' => 'Categories.Category',
				'CategoryOrder' => 'Categories.CategoryOrder',
				'WorkflowComment' => 'Workflow.WorkflowComment',
			)
		),
		'Categories.Category',
		'NetCommons.OriginalKey',
		//多言語
		'M17n.M17n' => array(
			'keyField' => 'block_id'
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array_merge($this->validate, array(
			//'block_id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		//'allowEmpty' => false,
			//		//'required' => true,
			//	)
			//),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),

			//status to set in PublishableBehavior.

			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('tinydb', 'Tinydb name')),
					'required' => true
				),
			),
		));

		//if (! parent::beforeValidate($options)) {
		//	return false;
		//}

		if (isset($this->data['TinydbSetting'])) {
			$this->TinydbSetting->set($this->data['TinydbSetting']);
			if (! $this->TinydbSetting->validates()) {
				$this->validationErrors = array_merge($this->validationErrors,
					$this->TinydbSetting->validationErrors);
				return false;
			}
		}

		if (isset($this->data['TinydbFrameSetting']) && ! $this->data['TinydbFrameSetting']['id']) {
			$this->TinydbFrameSetting->set($this->data['TinydbFrameSetting']);
			if (! $this->TinydbFrameSetting->validates()) {
				$this->validationErrors = array_merge($this->validationErrors,
					$this->TinydbFrameSetting->validationErrors);
				return false;
			}
		}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		//TinydbSetting登録
		if (isset($this->TinydbSetting->data['TinydbSetting'])) {
			$this->TinydbSetting->set($this->TinydbSetting->data['TinydbSetting']);
			$this->TinydbSetting->save(null, false);
		}

		//TinydbFrameSetting登録
		if (isset($this->TinydbFrameSetting->data['TinydbFrameSetting'])
			&& ! $this->TinydbFrameSetting->data['TinydbFrameSetting']['id']) {
			if (! $this->TinydbFrameSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		parent::afterSave($created, $options);
	}

/**
 * Create tinydb data
 *
 * @return array
 */
	public function createTinydb() {
		$this->loadModels(['TinydbSetting' => 'Tinydb.TinydbSetting']);

		$tinydb = $this->createAll(array(
			'Tinydb' => array(
				'name' => __d('tinydb', 'New tinydb %s', date('YmdHis')),
			),
			'Block' => array(
				'room_id' => Current::read('Room.id'),
				'language_id' => Current::read('Language.id'),
			),
		));

		return ($tinydb + $this->TinydbSetting->createBlockSetting());
	}

/**
 * Get tinydb data
 *
 * @return array
 */
	public function getTinydb() {
		$this->loadModels(['TinydbSetting' => 'Tinydb.TinydbSetting']);

		$tinydb = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $this->getBlockConditionById(),
		));
		if (! $tinydb) {
			return $tinydb;
		}
		$tinydbSetting = $this->TinydbSetting->getTinydbSetting();
		if ($tinydbSetting) {
			$tinydb = $tinydb + $tinydbSetting;
		}
		return $tinydb;
	}

/**
 * Save tinydb
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveTinydb($data) {
		$this->loadModels([
			'TinydbSetting' => 'Tinydb.TinydbSetting',
			'TinydbFrameSetting' => 'Tinydb.TinydbFrameSetting',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * Delete tinydb
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteTinydb($data) {
		$this->loadModels([
			'Tinydb' => 'Tinydb.Tinydb',
			'TinydbItem' => 'Tinydb.TinydbItem',
		]);

		//トランザクションBegin
		$this->begin();

		try {
			$conditions = array($this->alias . '.key' => $data['Tinydb']['key']);
			if (! $this->deleteAll($conditions, false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->TinydbItem->blockKey = $data['Block']['key'];
			$tinydbEntryConditions = array(
				$this->TinydbItem->alias . '.tinydb_key' => $data['Tinydb']['key']
			);
			if (! $this->TinydbItem->deleteAll($tinydbEntryConditions, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
