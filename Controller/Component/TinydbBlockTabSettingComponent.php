<?php
App::uses('Component', 'Controller');

/**
 * Class TinydbBlockTabSettingComponent
 */
class TinydbBlockTabSettingComponent extends Component {

/**
 * beforeRender
 *
 * BlockTabHelperの設定
 *
 * @param Controller $controller BlockTabHelperを使うコントローラ
 * @return void
 */
	public function beforeRender(Controller $controller) {
		$controller->helpers['Blocks.BlockTabs'] = array(
			'mainTabs' => array(
				'block_index' => array('url' => array('controller' => \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_blocks')),
				'frame_settings' => array('url' => array('controller' => \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_frame_settings')),
			),
			'blockTabs' => array(
				'block_settings' => array('url' => array('controller' => \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_blocks')),
				'mail_settings',
				'role_permissions' => array('url' => array('controller' => \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_block_role_permissions')),
			),
		);
		parent::beforeRender($controller);
	}

}