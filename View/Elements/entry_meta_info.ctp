<div class="tinydb_entry_meta">
	<div>

		<?php echo __d(
			'tinydb',
			'posted : %s',
			$this->Date->dateFormat($tinydbEntry['TinydbItem']['publish_start'])
		); ?>&nbsp;

		<?php echo $this->NetCommonsHtml->handleLink($tinydbEntry, array('avatar' => true)); ?>&nbsp;
		<?php echo __d('tinydb', 'Category') ?>:<?php echo $this->NetCommonsHtml->link(
			$tinydbEntry['CategoriesLanguage']['name'],
			array(
				'controller' => 'tinydb_items',
				'action' => 'index',
				'frame_id' => Current::read('Frame.id'),
				'category_id' => $tinydbEntry['TinydbItem']['category_id']
			)
		); ?>
	</div>
</div>
