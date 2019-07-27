<?php
/**
 * TinydbAppModel
 */
App::uses('AppModel', 'Model');

/**
 * Class TinydbAppModel
 */
class TinydbAppModel extends AppModel {

	protected function _triggerEvent(string $localEventName, &...$args) {
		$dbType = \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbType();
		$fullEventName = $dbType . '.Tinydb.Model.' . $localEventName;
		\Edumap\Tinydb\Lib\EventManager::instance()->dispatchByArray($fullEventName, $args);
	}
}
