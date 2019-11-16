<div class="clearfix tinydb_item_reaction">
	<div class="pull-left">
		<?php if ($tinydbSetting['use_sns'] ?? false) : ?>

			<?php $contentUrl = FULL_BASE_URL . $this->NetCommonsHtml->url(array(
					'action' => 'view',
					'frame_id' => Current::read('Frame.id'),
					'key' => $tinydbItem['TinydbItem']['key'],
				));
			?>
			<?php /* パフォーマンス改善のため、一覧表示でFacebook、Twitterボタンは表示しない。詳細画面で表示する */ ?>
			<?php if (!isset($index)) : ?>
				<?php echo $this->SnsButton->facebook($contentUrl);?>
				<div class="pull-left">
					<?php echo $this->SnsButton->twitter($contentUrl, $tinydbItem['TinydbItem']['title']);?>
				</div>
			<?php endif ?>
		<?php endif ?>

		<div class="pull-left">
			<?php if (isset($index) && ($index === true)) : ?>
				<span class="tinydb__content-comment-count">
			<?php echo $this->ContentComment->count($tinydbItem); ?>
		</span>
			<?php endif ?>
		</div>

		<div class="pull-left">
			<?php echo $this->Like->buttons('TinydbItem', $tinydbSetting, $tinydbItem, array('div' => true)); ?>
		</div>
	</div>
</div>
