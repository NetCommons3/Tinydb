<?php
/**
 * All TinydbBlockRolePermissionsController Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * require
 */
require_once CakePlugin::path('Tinydb') . 'Lib/TinydbFunctions.php';

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * All TinydbBlockRolePermissionsController Test suite
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Tinydb\Test\Case\TinydbBlockRolePermissionsController
 */
class AllTinydbControllerTinydbBlockRolePermissionsControllerTest extends NetCommonsTestSuite {

/**
 * All TinydbBlockRolePermissionsController Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$name = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s tests', $name));
		$suite->addTestDirectoryRecursive(__DIR__ . DS . 'TinydbBlockRolePermissionsController');
		return $suite;
	}

}
