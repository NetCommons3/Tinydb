<?php


namespace NetCommons\Tinydb\Lib;


class CurrentDbType {

	/**
	 * @var self
	 */
	private static $selfInstance;

	/**
	 * @var string
	 */
	private $dbType;

	public static function initByPlugin(string $pluginKey) : self {
		$dbType = $pluginKey;
		self::$selfInstance = new self($dbType);
		return self::$selfInstance;
	}

	private static function __convertDbTypeByDefaultSettingAction(string $defaultSettingAction) : string  {
		if (preg_match('/db_type:(.+)$/', $defaultSettingAction, $matches)) {
			return $matches[1];
		}
		throw new \LogicException('Tinydbのフレームではない');
	}

	private function __construct(string $dbType) {
		$this->dbType = \Inflector::camelize($dbType);
	}

	public static function instance() {
		//if (self::$selfInstance === null) {
		//	throw new \LogicException('先にinitByFrame()で初期化してください');
		//}
		return self::$selfInstance;
	}

	public function getDbType() : string {
		return $this->dbType;
	}

	public function getDbTypeKey() : string {
		return \Inflector::underscore($this->dbType);
	}

	public function isSingleDb() : bool {
		// TODO 複数DB使いたいのがでてきたら、DB毎に変更できるようにする
		return true;
	}
}