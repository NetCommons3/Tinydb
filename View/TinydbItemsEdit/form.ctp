<?php echo $this->NetCommonsHtml->script([
	'/tinydb/js/tinydb.js',
	'/tinydb/js/tinydb_entry_edit.js',
	'/tags/js/tags.js',
]); ?>
<?php
$dataJson = json_encode(
	$this->NetCommonsTime->toUserDatetimeArray($this->request->data, array('TinydbItem.publish_start'))
);
?>
<div class="tinydbEntries form" ng-controller="Tinydb" ng-init="init(<?php echo h($dataJson) ?>)">
	<article>
		<h1><?php echo h($tinydb['Tinydb']['name']) ?></h1>
		<div class="panel panel-default">

			<?php echo $this->NetCommonsForm->create(
				'TinydbItem',
				array(
					'inputDefaults' => array(
						'div' => 'form-group',
						'class' => 'form-control',
						'error' => false,
					),
					'div' => 'form-control',
					'novalidate' => true
				)
			);
			$this->NetCommonsForm->unlockField('Tag');
			?>
			<?php echo $this->NetCommonsForm->hidden('key'); ?>
			<?php echo $this->NetCommonsForm->hidden('Frame.id', array(
						'value' => Current::read('Frame.id'),
					)); ?>
			<?php echo $this->NetCommonsForm->hidden('Block.id', array(
				'value' => Current::read('Block.id'),
			)); ?>

			<div class="panel-body">

				<fieldset>

					<?php
					echo $this->TitleIcon->inputWithTitleIcon(
						'title',
						'TinydbItem.title_icon',
						array(
							'label' => __d('tinydb', 'Title'),
							'required' => 'required',
						)
					);
					?>
					<?php echo $this->NetCommonsForm->wysiwyg('TinydbItem.body1', array(
						'label' => __d('tinydb', 'Body1'),
						'required' => true,
						'rows' => 12
					));?>

					<div>
						<label><input type="checkbox" ng-model="writeBody2"/><?php echo __d('tinydb', 'Write body2') ?>
						</label>
					</div>

					<div class="form-group" ng-show="writeBody2">
					<?php echo $this->NetCommonsForm->wysiwyg('TinydbItem.body2', array(
						'label' => __d('tinydb', 'Body2'),
						'rows' => 12
					));?>
					</div>

					<?php
					echo $this->NetCommonsForm->input('publish_start',
						array(
							'type' => 'datetime',
							'required' => 'required',
							'label' => __d('tinydb', 'Published datetime'),
							'childDiv' => ['class' => 'form-inline'],
						)
					);
					?>

					<?php echo $this->Category->select('TinydbItem.category_id', array('empty' => true)); ?>

					<?php echo $this->element(
						'Tags.tag_form',
						array(
							'tagData' => isset($this->request->data['Tag']) ? $this->request->data['Tag'] : array(),
							'modelName' => 'TinydbItem',
						)
					); ?>

				</fieldset>

				<hr/>
				<?php echo $this->Workflow->inputComment('TinydbItem.status'); ?>

			</div>

			<?php echo $this->Workflow->buttons('TinydbItem.status'); ?>

			<?php echo $this->NetCommonsForm->end() ?>

			<?php if ($isEdit && $isDeletable) : ?>
				<div  class="panel-footer" style="text-align: right;">
					<?php echo $this->NetCommonsForm->create('TinydbItem',
						array(
							'type' => 'delete',
							'url' => NetCommonsUrl::blockUrl(
								array('controller' => 'tinydb_items_edit', 'action' => 'delete', 'frame_id' => Current::read('Frame.id')))
						)
					) ?>
					<?php echo $this->NetCommonsForm->input('key', array('type' => 'hidden')); ?>

					<?php echo $this->Button->delete('', __d('net_commons', 'Deleting the %s. Are you sure to proceed?', __d('tinydb', 'TinydbItem')));?>

					<?php echo $this->NetCommonsForm->end() ?>
				</div>
			<?php endif ?>

		</div>

		<?php echo $this->Workflow->comments(); ?>

	</article>

</div>


