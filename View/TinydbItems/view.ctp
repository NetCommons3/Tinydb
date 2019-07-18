<?php
echo $this->NetCommonsHtml->css([
	'/tinydb/css/tinydb.css',
	'/likes/css/style.css',
]);
echo $this->NetCommonsHtml->script([
	'/likes/js/likes.js',
]);
//debug($this->NetCommonsHtml->url());
echo $this->TinydbOgp->ogpMetaByTinydbItem($tinydbEntry);
?>

<header class="clearfix">
	<div class="pull-left">
		<?php echo $this->LinkButton->toList(); ?>
	</div>
	<div class="pull-right">
		<?php echo $this->element('Tinydb.TinydbItems/edit_link', array('status' => $tinydbEntry['TinydbItem']['status'])); ?>
	</div>
</header>

<article>

	<div class="tinydb_view_title clearfix">
		<?php echo $this->NetCommonsHtml->blockTitle(
				$tinydbEntry['TinydbItem']['title'],
				$tinydbEntry['TinydbItem']['title_icon'],
				array('status' => $this->Workflow->label($tinydbEntry['TinydbItem']['status']))
			); ?>
	</div>

	<?php echo $this->element('Tinydb.entry_meta_info'); ?>



	<div>
		<?php echo $tinydbEntry['TinydbItem']['body1']; ?>
	</div>
	<div>
		<?php echo $tinydbEntry['TinydbItem']['body2']; ?>
	</div>

	<?php echo $this->element('Tinydb.entry_footer'); ?>

	<!-- Tags -->
	<?php if (isset($tinydbEntry['Tag'])) : ?>
	<div>
		<?php echo __d('tinydb', 'tag'); ?>
		<?php foreach ($tinydbEntry['Tag'] as $tinydbTag): ?>
			<?php echo $this->NetCommonsHtml->link(
				$tinydbTag['name'],
				array('controller' => 'tinydb_items', 'action' => 'tag', 'frame_id' => Current::read('Frame.id'), 'id' => $tinydbTag['id'])
			); ?>&nbsp;
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<div>
		<?php /* コンテンツコメント */ ?>
		<?php echo $this->ContentComment->index($tinydbEntry); ?>
		<!--<div class="row">-->
		<!--	<div class="col-xs-12">-->
		<!--		--><?php //echo $this->element('ContentComments.index', array(
		//			'pluginKey' => $this->request->params['plugin'],
		//			'contentKey' => $tinydbEntry['TinydbItem']['key'],
		//			'isCommentApproved' => $tinydbSetting['use_comment_approval'],
		//			'useComment' => $tinydbSetting['use_comment'],
		//			'contentCommentCnt' => $tinydbEntry['ContentCommentCnt']['cnt'],
		//			'redirectUrl' => $this->NetCommonsHtml->url(array('plugin' => 'tinydb', 'controller' => 'tinydb_items', 'action' => 'view', 'frame_id' => Current::read('Frame.id'), 'key' => $tinydbEntry['TinydbItem']['key'])),
		//		)); ?>
		<!--	</div>-->
		<!--</div>-->
	</div>
</article>


