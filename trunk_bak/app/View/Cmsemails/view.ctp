<div class="cmsemails view">
<h2><?php  echo __('Cmsemail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mailfrom'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['mailfrom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mailsubject'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['mailsubject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mailcontent'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['mailcontent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($cmsemail['Cmsemail']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cmsemail'), array('action' => 'edit', $cmsemail['Cmsemail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cmsemail'), array('action' => 'delete', $cmsemail['Cmsemail']['id']), null, __('Are you sure you want to delete # %s?', $cmsemail['Cmsemail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cmsemails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cmsemail'), array('action' => 'add')); ?> </li>
	</ul>
</div>
