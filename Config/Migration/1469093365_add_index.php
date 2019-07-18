<?php
/**
 * AddIndex
 */

/**
 * Class AddIndex
 */
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tinydb_items' => array(
					'indexes' => array(
						'block_id' => array('column' => array('block_id', 'language_id'), 'unique' => 0),
					),
				),
				'tinydb_frame_settings' => array(
					'indexes' => array(
						'frame_key' => array('column' => 'frame_key', 'unique' => 0),
					),
				),
				'tinydb_settings' => array(
					'indexes' => array(
						'tinydb_key' => array('column' => 'tinydb_key', 'unique' => 0),
					),
				),
				'tinydb' => array(
					'indexes' => array(
						'block_id' => array('column' => 'block_id', 'unique' => 0),
					),
				),
			),
			'alter_field' => array(
				'tinydb_items' => array(
					'block_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
				'tinydb_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
				),
				'tinydb_settings' => array(
					'tinydb_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'Tinydb key | Tinydbキー | Hash値 | ', 'charset' => 'utf8'),
				),
				'tinydb' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'tinydb_items' => array('indexes' => array('block_id')),
				'tinydb_frame_settings' => array('indexes' => array('frame_key')),
				'tinydb_settings' => array('indexes' => array('tinydb_key')),
				'tinydb' => array('indexes' => array('block_id')),
			),
			'alter_field' => array(
				'tinydb_items' => array(
					'block_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
				),
				'tinydb_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
				),
				'tinydb_settings' => array(
					'tinydb_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Tinydb key | Tinydbキー | Hash値 | ', 'charset' => 'utf8'),
				),
				'tinydb' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
