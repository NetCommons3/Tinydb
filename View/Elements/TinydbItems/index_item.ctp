<article class="tinydb_item" ng-controller="Tinydb.Entries.Item">
	<h2 class="tinydb_item_title">
		<?php echo $this->TitleIcon->titleIcon($tinydbItem['TinydbItem']['title_icon']); ?>
		<?php echo $this->NetCommonsHtml->link(
			$tinydbItem['TinydbItem']['title'],
			array(
				'controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items',
				'action' => 'view',
				//'frame_id' => Current::read('Frame.id'),
				'key' => $tinydbItem['TinydbItem']['key']
			)
		);
		?>
		<?php echo $this->Workflow->label($tinydbItem['TinydbItem']['status']); ?>
	</h2>
	<?php echo $this->element('Tinydb.item_meta_info', array('tinydbItem' => $tinydbItem)); ?>

	<div class="clearfix tinydb_item_body1">
		<?php echo $tinydbItem['TinydbItem']['body1']; ?>
	</div>
	<?php if ($tinydbItem['TinydbItem']['body2']) : ?>
		<div class="clearfix" ng-hide="isShowBody2">
			<a ng-click="showBody2()"><?php echo __tinydbd('tinydb', 'Read more'); ?></a>
		</div>
		<div class="clearfix" ng-show="isShowBody2">
			<?php echo $tinydbItem['TinydbItem']['body2'] ?>
		</div>
		<div class="clearfix" ng-show="isShowBody2">
			<a ng-click="hideBody2()"><?php echo __tinydbd('tinydb', 'Close'); ?></a>
		</div>
	<?php endif ?>
	<?php echo $this->element('Tinydb.item_footer', array('tinydbItem' => $tinydbItem, 'index' => true)); ?>
</article>
