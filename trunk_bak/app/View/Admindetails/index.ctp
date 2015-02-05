<div class="admindetails index">
	<h2><?php echo __('Admindetails'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('admin_id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('zip'); ?></th>
			<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('company'); ?></th>
			<th><?php echo $this->Paginator->sort('company_logo'); ?></th>
			<th><?php echo $this->Paginator->sort('signature'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($admindetails as $admindetail): ?>
	<tr>
		<td><?php echo h($admindetail['Admindetail']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($admindetail['Admin']['id'], array('controller' => 'admins', 'action' => 'view', $admindetail['Admin']['id'])); ?>
		</td>
		<td><?php echo h($admindetail['Admindetail']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['city']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['state']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['country']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['zip']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['address']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['company']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['company_logo']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['signature']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['image']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['status']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['created']); ?>&nbsp;</td>
		<td><?php echo h($admindetail['Admindetail']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $admindetail['Admindetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $admindetail['Admindetail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $admindetail['Admindetail']['id']), null, __('Are you sure you want to delete # %s?', $admindetail['Admindetail']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Admindetail'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Admins'), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin'), array('controller' => 'admins', 'action' => 'add')); ?> </li>
	</ul>
</div>
