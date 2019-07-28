<?php
App::uses('TinydbAppModel', 'Tinydb.Model');

/**
 * Class Attendance
 */
abstract class AbstractTinydb extends TinydbAppModel {

/**
 * afterFrameSave
 *
 * @param array $frame Frame data
 * @return void
 */
	public function afterFrameSave(array $frame) {
		$this->__convertToTinydbFrame($frame);
	}

/**
 * フレームをTinydbのフレームにする
 *
 * @param array $frame Frame data
 * @return void
 */
	private function __convertToTinydbFrame(array $frame) {
		$frame['Frame']['plugin_key'] = 'tinydb';
		$dbType = Inflector::underscore(get_class($this));
		$frame['Frame']['default_setting_action'] = 'tinydb_blocks/index/db_type:' . $dbType;
		$frameModel = ClassRegistry::init('Frames.Frame');
		$frameModel->create();
		$frameModel->save($frame, ['callbacks' => false]);
	}
}