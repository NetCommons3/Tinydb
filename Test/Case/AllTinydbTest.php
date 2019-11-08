<?php
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';
/**
 * All _Test Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

// travis-ciでのテスト用
$autoloadPath = getenv('TRAVIS_BUILD_DIR') . '/vendors/autoload.php';
if (file_exists($autoloadPath)) {
	require_once $autoloadPath;
}
//if (file_exists(__DIR__ .'/../../vendors/autoload.php')) {
//	require_once __DIR__ .'/../../vendors/autoload.php';
//}
/**
 * All _Test Test suite
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\_Test
 */
class AllTinydbTest extends NetCommonsTestSuite {

/**
 * All _Test Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s Plugin tests', $plugin));
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case');
		return $suite;
	}
}
