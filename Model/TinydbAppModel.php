<?php
/**
 * TinydbAppModel
 */
App::uses('AppModel', 'Model');

/**
 * Class TinydbAppModel
 */
class TinydbAppModel extends AppModel {

	public function __construct($id = false, $table = null, $ds = null) {
		$dbType = \Edumap\Tinydb\Lib\CurrentDbType::instance();
		if ($dbType !== null) {
			$this->plugin = $dbType->getDbType();
		}
		parent::__construct($id, $table, $ds);
	}

	protected function _triggerEvent(string $localEventName, &...$args) {
		$dbType = \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbType();
		$fullEventName = $dbType . '.Tinydb.Model.' . $localEventName;
		\Edumap\Tinydb\Lib\EventManager::instance()->dispatchByArray($fullEventName, $args);
	}

	protected function _setUpDbType() {
		// Migration実行時にdbType不定になるので
		$dbTypeInstance = \Edumap\Tinydb\Lib\CurrentDbType::instance();
		if ($dbTypeInstance === null) {
			return;
		}
		$dbType = $dbTypeInstance->getDbType();
		$pluginName = $dbType;
		$modelName = str_replace('Tinydb', $dbType, get_class($this));
		$dbModel = ClassRegistry::init($pluginName . '.' . $modelName, true);
		if ($dbModel) {
			$this->hasOne[$modelName] = [
				'className' => $pluginName . '.' . $modelName,
				'conditions' => [

				]
			];
			$this->$modelName = $dbModel;
		}
	}


}
