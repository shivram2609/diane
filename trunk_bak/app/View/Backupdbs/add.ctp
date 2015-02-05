<div class="backupdbs form">
<?php echo $this->Form->create('Backupdb'); ?>
	<fieldset>
		<legend><?php echo __('Add Backupdb'); ?></legend>
	<?php
		echo $this->Form->input('filename');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Backupdbs'), array('action' => 'index')); ?></li>
	</ul>
</div>
