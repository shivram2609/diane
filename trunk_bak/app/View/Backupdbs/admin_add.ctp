<div class="backupdbs form">
<?php echo $this->Form->create('Backupdb'); ?>
	<fieldset>
		<legend><?php echo __('Create Backup'); ?></legend>
	<?php
		echo $this->Form->input('filename');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

