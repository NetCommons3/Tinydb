<?php
/**
 * TinydbSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Block.id'); ?>
<?php echo $this->Form->hidden('Block.key'); ?>

<?php echo $this->element('Blocks.block_creatable_setting', array(
	'settingPermissions' => array(
		'content_creatable' => __tinydbd('blocks', 'Content creatable roles'),
		'content_comment_creatable' => array(
			'label' => __tinydbd('blocks', 'Content comment creatable roles'),
			'help' => __tinydbd('content_comments', 'Content comment creatable roles help'),
		),
	),
)); ?>

<?php echo $this->element('Blocks.block_approval_setting', array(
	'model' => 'TinydbSetting',
	'useWorkflow' => 'use_workflow',
	'useCommentApproval' => 'use_comment_approval',
	'settingPermissions' => array(
		'content_comment_publishable' => __tinydbd('blocks', 'Content comment publishable roles'),
	),
	'options' => array(
		Block::NEED_APPROVAL => __tinydbd('blocks', 'Need approval in both %s and comments ', __tinydbd('tinydb', 'TinydbItem')),
		Block::NEED_COMMENT_APPROVAL => __tinydbd('blocks', 'Need only comments approval'),
		Block::NOT_NEED_APPROVAL => __tinydbd('blocks', 'Not need approval'),
	),
));
