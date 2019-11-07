<?php
if (isset($cssList) && !empty($cssList)) {
	echo $this->NetCommonsHtml->css($cssList);
}
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
						);?>"><?php echo __tinydbd('tinydb', 'All Entries') ?></a></li>

					<?php if ($categories):?>
						<li role="presentation" class="dropdown-header"><?php echo __tinydbd('tinydb', 'Category') ?></li>

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
					<?php endif; ?>

					<li role="presentation" class="divider"></li>

					<li role="presentation" class="dropdown-header"><?php echo __tinydbd('tinydb', 'Archive')?></li>
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
				'controller' => \NetCommons\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items_edit',
				'action' => 'add',
				'frame_id' => Current::read('Frame.id')
			);
			echo $this->Button->addLink('',
				$addUrl,
			array('tooltip' => __tinydbd('tinydb', 'Add item')));
			?>
		</div>
		<?php endif ?>

	</header>

	<?php if (count($tinydbEntries) == 0): ?>
		<div class="nc-not-found">
			<?php echo __tinydbd('net_commons', '%s is not.', __tinydbd('tinydb', 'TinydbItem')); ?>
		</div>

	<?php else : ?>
		<div class="nc-content-list">
			<?php foreach ($tinydbEntries as $tinydbItem): ?>

				<?php echo $this->element('Tinydb.TinydbItems/index_item', ['tinydbItem' => $tinydbItem]);?>

			<?php endforeach; ?>

			<?php echo $this->element('NetCommons.paginator') ?>
		</div>
	<?php endif?>

</article>
