<div class="tinydb_item_meta">
	<div>

		<?php echo __tinydbd(
			'tinydb',
			'posted : %s',
			$this->Date->dateFormat($tinydbItem['TinydbItem']['publish_start'])
		); ?>&nbsp;

		<?php echo $this->NetCommonsHtml->handleLink($tinydbItem, array('avatar' => true)); ?>&nbsp;
		<?php echo __tinydbd('tinydb', 'Category') ?>:<?php echo $this->NetCommonsHtml->link(
			$tinydbItem['CategoriesLanguage']['name'],
			array(
				'controller' => \Edumap\Tinydb\Lib\CurrentDbType::instance()->getDbTypeKey() . '_items',
				'action' => 'index',
				'frame_id' => Current::read('Frame.id'),
				'category_id' => $tinydbItem['TinydbItem']['category_id']
			)
		); ?>
	</div>
</div>
