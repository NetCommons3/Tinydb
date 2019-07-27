<?php
App::uses('View', 'View');

class TinydbView extends View {
	protected function _paths($plugin = null, $cached = true) {
		$paths = parent::_paths($plugin, $cached);
		if ($plugin === 'Tinydb') {
			$currentDbType = \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbType();
			$currentDbTypePaths = parent::_paths($currentDbType);
			$currentDbTypePaths = array_reverse($currentDbTypePaths);
			foreach ($currentDbTypePaths as $path) {
				if (strpos($path, $currentDbType) !== false) {
					array_unshift($paths, $path);
				}
			}
			$this->_pathsForPlugin['Tinydb'] = $paths;
			return $paths;
		}
		return $paths;
	}
}