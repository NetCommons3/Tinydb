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

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->Form->hidden('Tinydb.id'); ?>
<?php echo $this->Form->hidden('Tinydb.key'); ?>
<?php echo $this->Form->hidden('TinydbSetting.use_workflow'); ?>
<?php echo $this->Form->hidden('TinydbSetting.use_comment_approval'); ?>
<?php echo $this->Form->hidden('TinydbFrameSetting.id'); ?>
<?php echo $this->Form->hidden('TinydbFrameSetting.frame_key'); ?>
<?php echo $this->Form->hidden('TinydbFrameSetting.articles_per_page'); ?>
<?php //echo $this->Form->hidden('TinydbFrameSetting.comments_per_page'); ?>

<?php echo $this->NetCommonsForm->input('Tinydb.name', array(
		'type' => 'text',
		'label' => __tinydbd('tinydb', 'Tinydb name'),
		'required' => true,
	)); ?>

<?php echo $this->element('Blocks.public_type'); ?>

<?php echo $this->NetCommonsForm->inlineCheckbox('TinydbSetting.use_comment', array(
			'label' => __tinydbd('content_comments', 'Use comment')
	)); ?>

<?php echo $this->Like->setting('TinydbSetting.use_like', 'TinydbSetting.use_unlike');?>

<?php echo $this->NetCommonsForm->inlineCheckbox('TinydbSetting.use_sns', array(
	'label' => __tinydbd('tinydb', 'Use sns')
)); ?>

<?php
echo $this->element('Categories.edit_form', array(
	'categories' => isset($categories) ? $categories : null
));
?>
<?php echo $this->element('Blocks.modifed_info', array('displayModified' => true));
