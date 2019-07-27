<?php


namespace Edumap\Tinydb\Lib;


class CurrentDbType {

	/**
	 * @var self
	 */
	private static $self;

	/**
	 * @var string
	 */
	private $dbType;

	public static function initByFrame(array $frame) : self {
		$dbType = self::__convertDbTypeByDefaultSettingAction(
			$frame['default_setting_action'] ?? ''
		);
		self::$self = new self($dbType);
		return self::$self;
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
		return self::$self;
	}

	public function getDbType() : string {
		return $this->dbType;
	}
}