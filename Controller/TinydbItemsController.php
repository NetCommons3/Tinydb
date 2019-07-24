<?php
/**
 * TinydbEtnriesController
 */
App::uses('TinydbAppController', 'Tinydb.Controller');

/**
 * TinydbItems Controller
 *
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @property NetCommonsWorkflow $NetCommonsWorkflow
 * @property PaginatorComponent $Paginator
 * @property TinydbItem $TinydbItem
 * @property TinydbCategory $TinydbCategory
 * @property Category $Category
 */
class TinydbItemsController extends TinydbAppController {

/**
 * @var array use models
 */
	public $uses = array(
		'Tinydb.TinydbItem',
		'Workflow.WorkflowComment',
		'Categories.Category',
		//'ContentComments.ContentComment',	// コンテンツコメント
	);

/**
 * @var array helpers
 */
	public $helpers = array(
		'NetCommons.BackTo',
		'Workflow.Workflow',
		'Likes.Like',
		'ContentComments.ContentComment' => array(
			'viewVarsKey' => array(
				'contentKey' => 'tinydbItem.TinydbItem.key',
				'contentTitleForMail' => 'tinydbItem.TinydbItem.title',
				'useComment' => 'tinydbSetting.use_comment',
				'useCommentApproval' => 'tinydbSetting.use_comment_approval'
			)
		),
		'NetCommons.SnsButton',
		'NetCommons.TitleIcon',
		'NetCommons.DisplayNumber',
		'Tinydb.TinydbOgp',
	);

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
		//'NetCommons.NetCommonsWorkflow',
		//'NetCommons.NetCommonsRoomRole' => array(
		//	//コンテンツの権限設定
		//	'allowedActions' => array(
		//		'contentEditable' => array('edit', 'add'),
		//		'contentCreatable' => array('edit', 'add'),
		//	),
		//),
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
					//'add,edit,delete' => 'content_creatable',
					//'reply' => 'content_comment_creatable',
					//'approve' => 'content_comment_publishable',
			),
		),
		'Categories.Categories',
		'ContentComments.ContentComments' => array(
			'viewVarsKey' => array(
				'contentKey' => 'tinydbItem.TinydbItem.key',
				'useComment' => 'tinydbSetting.use_comment'
			),
			'allow' => array('view')
		)	);

/**
 * @var array 絞り込みフィルタ保持値
 */
	protected $_filter = array(
		'categoryId' => 0,
		'status' => 0,
		'yearMonth' => 0,
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		// ゲストアクセスOKのアクションを設定
		$this->Auth->allow('index', 'view', 'tag', 'year_month');
		//$this->Categories->initCategories();
		parent::beforeFilter();
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		if (! Current::read('Block.id')) {
			$this->autoRender = false;
			return;
		}

		$this->_prepare();
		$this->set('listTitle', $this->_tinydbTitle);
		$this->set('filterDropDownLabel', __d('tinydb', 'All Entries'));

		$conditions = array();
		$this->_filter['categoryId'] = isset($this->params['named']['category_id'])
			? $this->params['named']['category_id']
			: 0;
		if ($this->_filter['categoryId']) {
			$conditions['TinydbItem.category_id'] = $this->_filter['categoryId'];

			$category = $this->Category->find('first', [
				'recursive' => 0,
				'fields' => ['CategoriesLanguage.name'],
				'conditions' => ['Category.id' => $this->_filter['categoryId']],
			]);
			// カテゴリがみつからないならBadRequest
			if (!$category) {
				return $this->throwBadRequest();
			}
			$this->set(
				'listTitle', __d('tinydb', 'Category') . ':' . $category['CategoriesLanguage']['name']
			);
			$this->set('filterDropDownLabel', $category['CategoriesLanguage']['name']);
		}

		$this->_list($conditions);
	}

/**
 * tag別一覧
 *
 * @throws NotFoundException
 * @return void
 */
	public function tag() {
		$this->_prepare();
		// indexとのちがいはtagIdでの絞り込みだけ
		$tagId = isset($this->params['named']['id'])
			? $this->params['named']['id']
			: 0;

		// カテゴリ名をタイトルに
		$tag = $this->TinydbItem->getTagByTagId($tagId);
		if (!$tag) {
			throw new NotFoundException(__d('tags', 'Tag not found'));
		}
		$this->set('listTitle', __d('tinydb', 'Tag') . ':' . $tag['Tag']['name']);
		$this->set('filterDropDownLabel', '----');

		$conditions = array(
			'Tag.id' => $tagId // これを有効にするにはitem_tag_linkもJOINして検索か。
		);

		$this->_list($conditions);
	}

/**
 * 年月別一覧
 *
 * @return void
 */
	public function year_month() {
		$this->_prepare();
		// indexとの違いはyear_monthでの絞り込み
		$this->_filter['yearMonth'] = isset($this->params['named']['year_month'])
			? $this->params['named']['year_month']
			: 0;

		if (!preg_match('/^[0-9]{4}-[0-1][0-9]$/', $this->_filter['yearMonth'])) {
			// 年月としてありえない値だったらBadRequest
			return $this->throwBadRequest();
		}
		list($year, $month) = explode('-', $this->_filter['yearMonth']);
		if (is_numeric($year) && $month >= 1 && $month <= 12) {
			$this->set('listTitle', __d('tinydb', '%d-%d Tinydb Item List', $year, $month));
			$this->set('filterDropDownLabel', __d('tinydb', '%d-%d', $year, $month));

			$first = $this->_filter['yearMonth'] . '-1';
			$last = date('Y-m-t', strtotime($first));

			// 期間をサーバタイムゾーンに変換する
			$netCommonsTime = new NetCommonsTime();
			$first = $netCommonsTime->toServerDatetime($first);
			$last = $netCommonsTime->toServerDatetime($last);

			$conditions = array(
				'TinydbItem.publish_start BETWEEN ? AND ?' => array($first, $last)
			);
			$this->_list($conditions);
		} else {
			// 年月としてありえない値だったらBadRequest
			return $this->throwBadRequest();
		}
	}

/**
 * 権限の取得
 *
 * @return array
 */
	protected function _getPermission() {
		$permissionNames = array(
			'content_readable',
			'content_creatable',
			'content_editable',
			'content_publishable',
		);
		$permission = array();
		foreach ($permissionNames as $key) {
			$permission[$key] = Current::permission($key);
		}
		return $permission;
	}

/**
 * 一覧
 *
 * @param array $extraConditions 追加conditions
 * @return void
 */
	protected function _list($extraConditions = array()) {
		$this->set('currentCategoryId', $this->_filter['categoryId']);

		$this->set('currentYearMonth', $this->_filter['yearMonth']);

		$this->_setYearMonthOptions();

		$permission = $this->_getPermission();

		$conditions = $this->TinydbItem->getConditions(
			Current::read('Block.id'),
			$permission
		);
		if ($extraConditions) {
			$conditions = array_merge($conditions, $extraConditions);
		}
		$this->Paginator->settings = array_merge(
			$this->Paginator->settings,
			array(
				'conditions' => $conditions,
				'limit' => $this->_frameSetting['TinydbFrameSetting']['articles_per_page'],
				'order' => 'TinydbItem.publish_start DESC',
				//'fields' => '*, ContentCommentCnt.cnt',
			)
		);
		$this->TinydbItem->recursive = 0;
		$this->TinydbItem->Behaviors->load('ContentComments.ContentComment');
		$this->set('tinydbEntries', $this->Paginator->paginate('TinydbItem'));
		$this->TinydbItem->Behaviors->unload('ContentComments.ContentComment');
		$this->TinydbItem->recursive = -1;

		$this->view = 'index';
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @return void
 */
	public function view() {
		$this->_prepare();

		$key = $this->params['key'];

		$conditions = $this->TinydbItem->getConditions(
			Current::read('Block.id'),
			$this->_getPermission()
		);

		$conditions['TinydbItem.key'] = $key;

		$options = array(
			'conditions' => $conditions,
			'recursive' => 0,
		);
		$this->TinydbItem->recursive = 0;
		$this->TinydbItem->Behaviors->load('ContentComments.ContentComment');
		$tinydbItem = $this->TinydbItem->find('first', $options);
		$this->TinydbItem->Behaviors->unload('ContentComments.ContentComment');
		if ($tinydbItem) {
			$this->set('tinydbItem', $tinydbItem);

			//新着データを既読にする
			$this->TinydbItem->saveTopicUserStatus($tinydbItem);

			// tag取得
			//$tinydbTags = $this->TinydbTag->getTagsByItemId($tinydbItem['TinydbItem']['id']);
			//$this->set('tinydbTags', $tinydbTags);

			// コメントを利用する
			if ($this->_tinydbSetting['TinydbSetting']['use_comment']) {
				if ($this->request->is('post')) {
					// コメントする

					$tinydbItemKey = $tinydbItem['TinydbItem']['key'];
					$useCommentApproval = $this->_tinydbSetting['TinydbSetting']['use_comment_approval'];
					if (!$this->ContentComments->comment('tinydb', $tinydbItemKey,
						$useCommentApproval)) {
						return $this->throwBadRequest();
					}
				}
			}

		} else {
			// 表示できない記事へのアクセスならBadRequest
			return $this->throwBadRequest();
		}
	}

/**
 * 年月選択肢をViewへセット
 *
 * @return void
 */
	protected function _setYearMonthOptions() {
		// 年月と記事数
		$yearMonthCount = $this->TinydbItem->getYearMonthCount(
			Current::read('Block.id'),
			$this->_getPermission()
		);
		foreach ($yearMonthCount as $yearMonth => $count) {
			list($year, $month) = explode('-', $yearMonth);
			$options[$yearMonth] = __d('tinydb', '%d-%d (%s)', $year, $month, $count);
		}
		$this->set('yearMonthOptions', $options);
	}
}
