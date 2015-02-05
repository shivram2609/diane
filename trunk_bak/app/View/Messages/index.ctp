<div class="messages index">
	<h2><?php echo __('Messages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('campaign_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('reciever_id'); ?></th>
			<th><?php echo $this->Paginator->sort('subject'); ?></th>
			<th><?php echo $this->Paginator->sort('message'); ?></th>
			<th><?php echo $this->Paginator->sort('remarkflag'); ?></th>
			<th><?php echo $this->Paginator->sort('messagestatus'); ?></th>
			<th><?php echo $this->Paginator->sort('userdelstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('recvdelstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($messages as $message): ?>
	<tr>
		<td><?php echo h($message['Message']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($message['Campaign']['id'], array('controller' => 'campaigns', 'action' => 'view', $message['Campaign']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($message['User']['id'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
		</td>
		<td><?php echo h($message['Message']['reciever_id']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['subject']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['message']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['remarkflag']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['messagestatus']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['userdelstatus']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['recvdelstatus']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['created']); ?>&nbsp;</td>
		<td><?php echo h($message['Message']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $message['Message']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $message['Message']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $message['Message']['id']), null, __('Are you sure you want to delete # %s?', $message['Message']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Message'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Campaigns'), array('controller' => 'campaigns', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Campaign'), array('controller' => 'campaigns', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
