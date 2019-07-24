<?php
echo $this->NetCommonsHtml->css([
	'/tinydb/css/tinydb.css',
	'/likes/css/style.css',
]);
echo $this->NetCommonsHtml->script([
	'/tinydb/js/tinydb.js',
	'/likes/js/likes.js',
]);
?>

<article class="tinydbEntries index " ng-controller="Tinydb.Entries" ng-init="init(<?php echo Current::read('Frame.id') ?>)">
	<h1 class="tinydb_tinydbTitle"><?php echo h($listTitle) ?></h1>

	<header class="clearfix tinydb_navigation_header">
		<div class="pull-left">
			<span class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
					<span class="pull-left nc-drop-down-ellipsis">
						<?php echo h($filterDropDownLabel) ?>
					</span>
					<span class="pull-right">
						<span class="caret"></span>
					</span>
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $this->NetCommonsHtml->url(
							array(
								'action' => 'index',
								'frame_id' => Current::read('Frame.id'),
							)
						);?>"><?php echo __d('tinydb', 'All Entries') ?></a></li>
					<li role="presentation" class="dropdown-header"><?php echo __d('tinydb', 'Category') ?></li>

					<?php echo $this->Category->dropDownToggle(array(
						'empty' => false,
						'displayMenu' => false,
						'url' => NetCommonsUrl::actionUrlAsArray(
							array(
								'action' => 'index',
								'block_id' => Current::read('Block.id'),
								'frame_id' => Current::read('Frame.id'),
							)
						),
					)); ?>

					<li role="presentation" class="divider"></li>

					<li role="presentation" class="dropdown-header"><?php echo __d('tinydb', 'Archive')?></li>
					<?php foreach($yearMonthOptions as $yearMonth => $label): ?>

						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $this->NetCommonsHtml->url(
								array(
									'action' => 'year_month',
									'frame_id' => Current::read('Frame.id'),
									'year_month' => $yearMonth,
								)
							);?>"><?php echo $label ?></a></li>
					<?php endforeach ?>
				</ul>
			</span>
			<?php echo $this->DisplayNumber->dropDownToggle(); ?>
			<?php /* 表示件数 */ ?>


		</div>

		<?php if (Current::permission('content_creatable')) : ?>
		<div class="pull-right">
			<?php
			$addUrl = array(
				'controller' => 'tinydb_items_edit',
				'action' => 'add',
				'frame_id' => Current::read('Frame.id')
			);
			echo $this->Button->addLink('',
				$addUrl,
			array('tooltip' => __d('tinydb', 'Add item')));
			?>
		</div>
		<?php endif ?>

	</header>

	<?php if (count($tinydbEntries) == 0): ?>
		<div class="nc-not-found">
			<?php echo __d('net_commons', '%s is not.', __d('tinydb', 'TinydbItem')); ?>
		</div>

	<?php else : ?>
		<div class="nc-content-list">
			<?php foreach ($tinydbEntries as $tinydbItem): ?>

				<article class="tinydb_item" ng-controller="Tinydb.Entries.Item">
					<h2 class="tinydb_item_title">
						<?php echo $this->TitleIcon->titleIcon($tinydbItem['TinydbItem']['title_icon']); ?>
						<?php echo $this->NetCommonsHtml->link(
							$tinydbItem['TinydbItem']['title'],
							array(
								'controller' => 'tinydb_items',
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
							<a ng-click="showBody2()"><?php echo __d('tinydb', 'Read more'); ?></a>
						</div>
						<div class="clearfix" ng-show="isShowBody2">
							<?php echo $tinydbItem['TinydbItem']['body2'] ?>
						</div>
						<div class="clearfix" ng-show="isShowBody2">
							<a ng-click="hideBody2()"><?php echo __d('tinydb', 'Close'); ?></a>
						</div>
					<?php endif ?>
					<?php echo $this->element('Tinydb.item_footer', array('tinydbItem' => $tinydbItem, 'index' => true)); ?>
				</article>

			<?php endforeach; ?>

			<?php echo $this->element('NetCommons.paginator') ?>
		</div>
	<?php endif?>

</article>
