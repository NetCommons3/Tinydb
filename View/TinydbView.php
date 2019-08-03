<?php
App::uses('View', 'View');

class TinydbView extends View {
	protected function _paths($plugin = null, $cached = true) {
		$paths = parent::_paths($plugin, $cached);

		// TinydbのViewを使うときは具象プラグインのPathsを優先で追加
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

		// Tinydb具象プラグインを使うときはTinydbのViewPathsを劣後で追加
		if (\Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbType() === $plugin) {
			// TinydbのViewを劣後で追加
			$tinydbPaths = parent::_paths('Tinydb');
			$tinydbPaths = array_filter($tinydbPaths, function ($path) {
				return strpos($path, 'Tinydb') !== false;
			});

			$currentPluginPaths = array_filter($paths, function ($path) {
				return strpos($path, $this->plugin) !== false;
			});
			$otherPaths = array_filter($paths, function ($path) {
				return strpos($path, $this->plugin) === false;
			});
			$paths = array_merge($currentPluginPaths, $tinydbPaths, $otherPaths);
			$this->_pathsForPlugin[$this->plugin] = $paths;
		}
		return $paths;
	}
}