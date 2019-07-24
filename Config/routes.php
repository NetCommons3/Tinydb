<?php
Router::connect(
	'/tinydb/tinydb_items_edit/add_from_item/:key',
	[
		'plugin' => 'tinydb',
		'controller' => 'tinydb_items_edit',
		'action' => 'add_from_item',
		'?' => [
			'key' => ':key'
		]

	]
);