<?php
/**
 *  AddDbType Migration
 */

/**
 * Class AddDbType
 */
class AddDbType extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_db_type';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tinydb' => array(
					'db_type' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'dbType', 'charset' => 'utf8', 'after' => 'name'),
				),
			),
			'alter_field' => array(
				'tinydb' => array(
					'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'Tinydb名', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'Tinydbキー', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'tinydb' => array('db_type'),
			),
			'alter_field' => array(
				'tinydb' => array(
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Tinydb名', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Tinydbキー', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
