<?php
/**
 * tinydb post view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//公開権限があれば編集／削除できる
//もしくは　編集権限があれば 編集できる（ステータスは関係しない）
//もしくは 作成権限があり、自分の書いた記事であれあば編集できる（ステータスは関係しない）
// 公開されたコンテンツの削除は公開権限が必用。
?>
<?php if ($this->Workflow->canEdit('Tinydb.TinydbItem', $tinydbItem)) : ?>
	<div class="text-right">
		<?php echo $this->Button->editLink('',
			array(
				'controller' => 'tinydb_items_edit',
				'key' => $tinydbItem['TinydbItem']['key']
			),
			array(
				'tooltip' => true,
				//'iconSize' => 'btn-xs'
			)
		); ?>

		<?php echo $this->Button->addLink(
			__d('school_informations', 'この記事を元に追加'),
			array(
				'controller' => 'tinydb_items_edit',
				'action' => 'add_from_item',
				'key' => $tinydbItem['TinydbItem']['key'],
				'frame_id' => Current::read('Frame.id'),
			),
			array(
				'tooltip' => true,
				//'iconSize' => 'btn-xs'
			)
		); ?>

	</div>

<?php endif;
