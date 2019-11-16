<?php
/**
 * TinydbItem Model
 *
 * @property TinydbCategory $TinydbCategory
 * @property TinydbItemTagLink $TinydbItemTagLink
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TinydbAppModel', 'Tinydb.Model');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Summary for TinydbItem Model
 */
class TinydbItem extends TinydbAppModel {

/**
 * @var int recursiveはデフォルトアソシエーションなしに
 */
	public $recursive = -1;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
		'Tags.Tag',
		'NetCommons.OriginalKey',
		//'NetCommons.Publishable',
		'Workflow.Workflow',
		'Likes.Like',
		'Workflow.WorkflowComment',
		//'Categories.Category',
		'ContentComments.ContentComment',
		'Topics.Topics' => array(
			'fields' => array(
				'title' => 'title',
				'summary' => 'body1',
				// TODO tinydb_itemsじゃダメなんだな
				'path' => '/:plugin_key/{{db_type}}_items/view/:block_id/:content_key',
			),
			'search_contents' => array('body2')
		),
		// 自動でメールキューの登録, 削除。ワークフロー利用時はWorkflow.Workflowより下に記述する
		'Mails.MailQueue' => array(
			'embedTags' => array(
				'X-SUBJECT' => 'TinydbItem.title',
				'X-BODY' => 'TinydbItem.body1',
				'X-URL' => [
					'controller' => 'tinydb_items'
				]
			),
		),
		'Wysiwyg.Wysiwyg' => array(
			'fields' => array('body1', 'body2'),
		),
		//多言語
		'M17n.M17n' => array(
			'commonFields' => array(
				'category_id', 'title_icon',
			),
			'associations' => array(
				'TagsContent' => array(
					'class' => 'Tags.TagsContent',
					'foreignKey' => 'content_id',
					'fieldForIdentifyPlugin' => array('field' => 'model', 'value' => 'TinydbItem'),
					'isM17n' => true
				),
			),
			'afterCallback' => false,
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	//	'CategoryOrder' => array(
	//		'className' => 'Categories.CategoryOrder',
	//		'foreignKey' => false,
	//		'conditions' => 'CategoryOrder.category_key=Category.key',
	//		'fields' => '',
	//		'order' => ''
	//	)
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => array(
				'content_count' => array(
					'TinydbItem.is_origin' => true,
					'TinydbItem.is_latest' => true
				),
			),
		),
	);

/**
 * TinydbItem constructor.
 *
 * @param int|bool $id id
 * @param string|null $table table
 * @param mixed|null $ds ds
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->_setUpDbType();
		$this->__setUpTopicsPath();
		$this->_triggerEvent('TinydbItem.construct', $this);
		parent::__construct($id, $table, $ds);
	}

/**
 * Called before each find operation. Return false if you want to halt the find
 * call, otherwise return the (modified) query data.
 *
 * @param array $query Data used to execute this query, i.e. conditions, order, etc.
 * @return mixed true if the operation should continue, false if it should abort; or, modified
 *  $query to continue with new $query
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforefind
 */
	public function beforeFind($query) {
		$recursive = isset($query['recursive'])
			? $query['recursive']
			: null;
		if ($recursive > -1 &&
			! $this->id) {
			$belongsTo = $this->Category->bindModelCategoryLang('TinydbItem.category_id');
			$this->bindModel($belongsTo, true);
		}
		return true;
	}

/**
 * バリデートメッセージ多言語化対応のためのラップ
 *
 * @param array $options options
 * @return bool
 */
	public function beforeValidate($options = array()) {
		$this->validate = ValidateMerge::merge($this->validate, $this->_getValidateSpecification());
		return parent::beforeValidate($options);
	}

/**
 * afterSave
 *
 * @param bool $created created
 * @param array $options options
 * @return void
 */
	public function afterSave($created, $options = array()) {
		$this->_triggerEvent('TinydbItem.afterSave', $created, $options, $this->data);
		parent::afterSave($created, $options);
	}

/**
 * プラリマリキーを除いた新規レコード配列を返す
 * ex) array('ModelName' => array('filedName' => default, ...));
 *
 * @return array
 */
	protected function _getNew() {
		if (is_null($this->_newRecord)) {
			$newRecord = array();
			foreach ($this->_schema as $fieldName => $fieldDetail) {
				if ($fieldName != $this->primaryKey) {
					$newRecord[$this->name][$fieldName] = $fieldDetail['default'];
				}
			}
			$this->_newRecord = $newRecord;
		}
		return $this->_newRecord;
	}

/**
 * バリデーションルールを返す
 *
 * @return array
 */
	protected function _getValidateSpecification() {
		$validate = array(
			'title' => array(
				'notBlank' => [
					'rule' => array('notBlank'),
					'message' => sprintf(
						__tinydbd('net_commons', 'Please input %s.'),
						__tinydbd('tinydb', 'Title')
					),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'body1' => array(
				'notBlank' => [
					'rule' => array('notBlank'),
					'message' => sprintf(
						__tinydbd('net_commons', 'Please input %s.'),
						__tinydbd('tinydb', 'Body1')
					),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'publish_start' => array(
				'notBlank' => [
					'rule' => array('notBlank'),
					'message' => sprintf(__tinydbd('net_commons', 'Please input %s.'),
						__tinydbd('tinydb', 'Published datetime')
					),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
				'datetime' => [
					'rule' => array('datetime'),
					'message' => __tinydbd('net_commons', 'Invalid request.'),
				],
			),
			'category_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					'allowEmpty' => true,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			//'key' => array(
			//	'notBlank' => array(
			//		'rule' => array('notBlank'),
			//		//'message' => 'Your custom message here',
			//		//'allowEmpty' => false,
			//		//'required' => false,
			//		//'last' => false, // Stop validation after this rule
			//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//	),
			//),
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_auto_translated' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
		return $validate;
	}

/**
 * 空の新規データを返す
 *
 * @return array
 */
	public function getNew() {
		$new = $this->_getNew();
		$netCommonsTime = new NetCommonsTime();
		$new['TinydbItem']['publish_start'] = $netCommonsTime->getNowDatetime();

		$this->_triggerEvent('TinydbItem.getNew', $new);
		return $new;
	}

/**
 * UserIdと権限から参照可能なItemを取得するCondition配列を返す
 *
 * @param int $blockId ブロックId
 * @param array $permissions 権限
 * @return array condition
 */
	public function getConditions($blockId, $permissions) {
		$belongsTo = $this->Category->bindModelCategoryLang('TinydbItem.category_id');
		$this->bindModel($belongsTo, true);

		// contentReadable falseなら何も見えない
		if ($permissions['content_readable'] === false) {
			$conditions = array('TinydbItem.id' => 0); // ありえない条件でヒット0にしてる
			return $conditions;
		}

		// デフォルト絞り込み条件
		$conditions = array(
			'TinydbItem.block_id' => $blockId
		);

		$conditions = $this->getWorkflowConditions($conditions);

		return $conditions;
	}

/**
 * 年月毎の記事数を返す
 *
 * @param int $blockId ブロックID
 * @param array $permissions 権限
 * @return array
 */
	public function getYearMonthCount($blockId, $permissions) {
		$currentDateTime = NetCommonsTime::getNowDatetime();

		// CONVERT_TZを使ってユーザタイムゾーンで年月集計をだす。
		$netCommonsTime = new NetCommonsTime();
		$userTimeZone = $netCommonsTime->getUserTimezone();
		$userTimeZoneObject = new DateTimeZone($userTimeZone);

		$now = new DateTime($currentDateTime);
		$now->setTimezone($userTimeZoneObject);
		$timeOffset = $now->format('P'); // JSTなら+09:00
		$conditions = $this->getConditions($blockId, $permissions);
		// 年月でグループ化してカウント→取得できなかった年月をゼロセット
		$this->virtualFields['year_month'] = 0; // バーチャルフィールドを追加
		$this->virtualFields['count'] = 0; // バーチャルフィールドを追加
		$result = $this->find(
			'all',
			array(
				'fields' => array(
					'DATE_FORMAT(CONVERT_TZ(TinydbItem.publish_start,' .
					' \'+00:00\', \'' . $timeOffset . '\'), \'%Y-%m\') AS TinydbItem__year_month',
					'count(*) AS TinydbItem__count'
				),
				'conditions' => $conditions,
				'group' => array('TinydbItem__year_month'), //GROUP BY YEAR(record_date), MONTH(record_date)
			)
		);
		// 使ったバーチャルFieldを削除
		unset($this->virtualFields['year_month']);
		unset($this->virtualFields['count']);

		$ret = array();
		//　一番古い記事を取得
		$oldestItem = $this->find('first',
			array(
				'conditions' => $conditions,
				'order' => 'TinydbItem.publish_start ASC',
			)
		);

		// 一番古い記事の年月から現在までを先にゼロ埋め
		if (isset($oldestItem['TinydbItem'])) {
			$currentYearMonthDay = date('Y-m-01', strtotime(
				$netCommonsTime->toUserDatetime($oldestItem['TinydbItem']['publish_start'])));
		} else {
			// 記事がなかったら今月だけ
			$currentYearMonthDay = date('Y-m-01', strtotime($currentDateTime));
		}

		// 未来に公開予定の記事があったら、その記事の公開年月まで0うめした配列を用意する
		$latestConditions = $conditions;
		$latestConditions['TinydbItem.publish_start >='] = $currentDateTime;

		$latestTinydbItem = $this->find(
			'first',
			[
				'conditions' => $latestConditions,
				'order' => 'TinydbItem.publish_start DESC'
			]
		);
		if ($latestTinydbItem) {
			$endDateTime = $latestTinydbItem['TinydbItem']['publish_start'];
		} else {
			$endDateTime = $currentDateTime;
		}
		while ($currentYearMonthDay <= $endDateTime) {
			$ret[substr($currentYearMonthDay, 0, 7)] = 0;
			$currentYearMonthDay = date('Y-m-01', strtotime($currentYearMonthDay . ' +1 month'));
		}
		// 記事がある年月は記事数を上書きしておく
		foreach ($result as $yearMonth) {
			$ret[$yearMonth['TinydbItem']['year_month']] = (int)$yearMonth['TinydbItem']['count'];
		}

		//年月降順に並び替える
		krsort($ret);
		return $ret;
	}

/**
 * 記事の保存。タグも保存する
 *
 * @param array $data 登録データ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveItem($data) {
		// category_id=0だったらnullにする。そうしないと空文字としてSQL発行される
		if (empty($data[$this->alias]['category_id'])) {
			$data[$this->alias]['category_id'] = null;
		}

		$this->begin();
		try {
			$this->create(); // 常に新規登録
			// 先にvalidate 失敗したらfalse返す
			$this->set($data);
			if (!$this->validates($data)) {
				return false;
			}
			$savedData = $this->save($data, ['validate' => false]);
			if (! $savedData) {
				//このsaveで失敗するならvalidate以外なので例外なげる
				throw new InternalErrorException(__tinydbd('net_commons', 'Internal Server Error'));
			}

			// dbType別の保存
			$dbTypeModelName = key($this->hasOne ?? []);
			if ($dbTypeModelName) {
				$savedData[$dbTypeModelName]['tinydb_item_id'] = $this->id;
				$this->$dbTypeModelName->save($savedData);
			}

			//多言語化の処理
			$this->set($savedData);
			$this->saveM17nData();

			$this->commit();

		} catch (Exception $e) {
			$this->rollback($e);
		}
		return $savedData;
	}

/**
 * 記事削除
 *
 * @param int $key オリジンID
 * @throws InternalErrorException
 * @return bool
 */
	public function deleteItemByKey($key) {
		// ε(　　　　 v ﾟωﾟ)　＜タグリンク削除
		$this->begin();
		try{
			// 記事削除
			$this->contentKey = $key;
			$conditions = array('TinydbItem.key' => $key);
			if ($result = $this->deleteAll($conditions, true, true)) {
				$this->commit();
			} else {
				throw new InternalErrorException(__tinydbd('net_commons', 'Internal Server Error'));
			}
		} catch (Exception $e) {
			$this->rollback($e);
			//エラー出力
		}
		return $result;
	}

/**
 * 過去に一度も公開されてないか
 *
 * @param array $tinydbItem チェック対象記事
 * @return bool true:公開されてない false: 公開されたことあり
 */
	public function yetPublish($tinydbItem) {
		$conditions = array(
			'TinydbItem.key' => $tinydbItem['TinydbItem']['key'],
			'TinydbItem.is_active' => 1
		);
		$count = $this->find('count', array('conditions' => $conditions));
		return ($count == 0);
	}

/**
 * 新着プラグインのパスをDbTypeにあわせて変更する
 *
 * @return void
 */
	private function __setUpTopicsPath() {
		$dbTypeInstance = \NetCommons\Tinydb\Lib\CurrentDbType::instance();
		if ($dbTypeInstance === null) {
			return;
		}
		$dbType = $dbTypeInstance->getDbType();
		if ($dbType === 'Tinydb') {
			return;
		}
		$snakeCaseDbType = Inflector::underscore($dbType);
		$this->actsAs['Topics.Topics']['fields']['path'] = str_replace(
			'{{db_type}}',
			$snakeCaseDbType,
			$this->actsAs['Topics.Topics']['fields']['path']
		);
	}

}
