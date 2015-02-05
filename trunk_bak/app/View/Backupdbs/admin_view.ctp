<div class="backupdbs view">
<h2><?php  echo __('Backupdb'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($backupdb['Backupdb']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filename'); ?></dt>
		<dd>
			<?php echo h($backupdb['Backupdb']['filename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($backupdb['Backupdb']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Backupdb'), array('action' => 'edit', $backupdb['Backupdb']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Backupdb'), array('action' => 'delete', $backupdb['Backupdb']['id']), null, __('Are you sure you want to delete # %s?', $backupdb['Backupdb']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Backupdbs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Backupdb'), array('action' => 'add')); ?> </li>
	</ul>
</div>
