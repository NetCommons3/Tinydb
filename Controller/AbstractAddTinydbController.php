<?php
abstract class AbstractAddTinydbController extends AppController {

/**
 * add_frame
 *
 * @return void
 */
	public function add_frame() {
		$frameId = Current::read('Frame.id');
		$pageId = Current::read('Page.id');

		$url = [
			'plugin' => 'tinydb',
			'controller' => 'tinydb_blocks',
			'action' => 'index',
			'db_type' => 'attendance',
			'?' => [
				'frame_id' => $frameId,
				'page_id' => $pageId,
			],
			'#' => '!#frame-' . $frameId
		];
		$this->redirect($url);
	}
}