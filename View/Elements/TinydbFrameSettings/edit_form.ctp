<?php
/**
 * Tinydb frame setting element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>

<?php echo $this->NetCommonsForm->hidden('TinydbFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('TinydbFrameSetting.frame_key'); ?>

<?php echo $this->DisplayNumber->select('TinydbFrameSetting.articles_per_page', array(
	'label' => __d('net_commons', 'Display the number of each page'),
	'unit' => array(
		'single' => __d('tinydb', '%s article'),
		'multiple' => __d('tinydb', '%s articles')
	),
)); ?>
<?php //echo $this->DisplayNumber->select('TinydbFrameSetting.comments_per_page', array(
//	'label' => __d('tinydb', 'Show comments per page'),
//	'unit' => array(
//		'single' => __d('tinydb', '%s article'),
//		'multiple' => __d('tinydb', '%s articles')
//	),
//));
