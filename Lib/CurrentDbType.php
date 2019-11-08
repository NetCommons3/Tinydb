<?php
/**
 * Tinydb具象プラグインのDBタイプ
 */

namespace NetCommons\Tinydb\Lib;


/**
 * Class CurrentDbType
 *
 * @package NetCommons\Tinydb\Lib
 */
class CurrentDbType {

/**
 * @var self
 */
	private static $__selfInstance;

/**
 * @var string
 */
	private $__dbType;

/**
 * initByPlugin
 *
 * @param string $pluginKey Plugin key
 * @return CurrentDbType
 */
	public static function initByPlugin(string $pluginKey) : self {
		$dbType = $pluginKey;
		self::$__selfInstance = new self($dbType);
		return self::$__selfInstance;
	}

/**
 * CurrentDbType constructor.
 *
 * @param string $dbType dbType
 */
	private function __construct(string $dbType) {
		$this->__dbType = \Inflector::camelize($dbType);
	}

/**
 * instance
 *
 * @return CurrentDbType
 */
	public static function instance() {
		//if (self::$selfInstance === null) {
		//	throw new \LogicException('先にinitByFrame()で初期化してください');
		//}
		return self::$__selfInstance;
	}

/**
 * getDbType
 *
 * @return string
 */
	public function getDbType() {
		return $this->__dbType;
	}

/**
 * getDbTypeKey
 *
 * @return string
 */
	public function getDbTypeKey() {
		return \Inflector::underscore($this->__dbType);
	}

/**
 * isSingleDb
 *
 * @return bool
 */
	public function isSingleDb() {
		// HACK 複数DB使いたいのがでてきたら、DB毎に変更できるようにする
		return true;
	}
}