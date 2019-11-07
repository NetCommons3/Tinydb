<?php
echo $this->NetCommonsHtml->css([
	'/tinydb/css/tinydb.css',
	'/likes/css/style.css',
]);
echo $this->NetCommonsHtml->script([
	'/likes/js/likes.js',
]);
//debug($this->NetCommonsHtml->url());
echo $this->TinydbOgp->ogpMetaByTinydbItem($tinydbItem);
?>

<header class="clearfix">
	<div class="pull-left">
		<?php echo $this->LinkButton->toList(); ?>
	</div>
	<div class="pull-right">
		<?php echo $this->element('Tinydb.TinydbItems/edit_link', array('status' => $tinydbItem['TinydbItem']['status'])); ?>
	</div>
</header>

<article>

	<div class="tinydb_view_title clearfix">
		<?php echo $this->NetCommonsHtml->blockTitle(
				$tinydbItem['TinydbItem']['title'],
				$tinydbItem['TinydbItem']['title_icon'],
				array('status' => $this->Workflow->label($tinydbItem['TinydbItem']['status']))
			); ?>
	</div>

	<?php echo $this->element('Tinydb.item_meta_info'); ?>



	<div class="clearfix">
		<?php echo $tinydbItem['TinydbItem']['body1']; ?>
	</div>
	<div class="clearfix">
		<?php echo $tinydbItem['TinydbItem']['body2']; ?>
	</div>

	<?php echo $this->element('Tinydb.item_footer'); ?>

	<!-- Tags -->
	<?php if (isset($tinydbItem['Tag'])) : ?>
	<div>
		<?php echo __tinydbd('tinydb', 'tag'); ?>
		<?php foreach ($tinydbItem['Tag'] as $tinydbTag): ?>
			<?php echo $this->NetCommonsHtml->link(
				$tinydbTag['name'],
				array('controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items', 'action' => 'tag', 'frame_id' => Current::read('Frame.id'), 'id' => $tinydbTag['id'])
			); ?>&nbsp;
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<div>
		<?php /* コンテンツコメント */ ?>
		<?php echo $this->ContentComment->index($tinydbItem); ?>
		<!--<div class="row">-->
		<!--	<div class="col-xs-12">-->
		<!--		--><?php //echo $this->element('ContentComments.index', array(
		//			'pluginKey' => $this->request->params['plugin'],
		//			'contentKey' => $tinydbItem['TinydbItem']['key'],
		//			'isCommentApproved' => $tinydbSetting['use_comment_approval'],
		//			'useComment' => $tinydbSetting['use_comment'],
		//			'contentCommentCnt' => $tinydbItem['ContentCommentCnt']['cnt'],
		//			'redirectUrl' => $this->NetCommonsHtml->url(array('plugin' => 'tinydb', 'controller' => 'tinydb_items', 'action' => 'view', 'frame_id' => Current::read('Frame.id'), 'key' => $tinydbItem['TinydbItem']['key'])),
		//		)); ?>
		<!--	</div>-->
		<!--</div>-->
	</div>
</article>


