<?php
/**
 * Tinydb frame setting template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_FRAME_SETTING); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
			'model' => 'TinydbFrameSetting',
			'action' => NetCommonsUrl::actionUrl(array(
				'controller' => $this->params['controller'],
				'action' => 'edit',
				'frame_id' => Current::read('Frame.id')
			)),
			'callback' => 'Tinydb.TinydbFrameSettings/edit_form',
			'cancelUrl' => NetCommonsUrl::backToPageUrl(),
		)); ?>
	</div>
</article>
