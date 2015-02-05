<div class="container">
	<h1 class="heading2">My Courses</h1>
	<?php echo $this->Session->flash(); ?>
	<div class="open_contract_table">
	<table cellpadding="0" cellspacing="0" width="100%" class="contract_tble">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('subtitle'); ?></th>
			<th><?php echo $this->Paginator->sort('pricetype'); ?></th>
			<th><?php echo $this->Paginator->sort('summary'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Created By'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($courses as $course): ?>
	<tr>
		<td><?php echo h($course['Course']['id']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['title']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['subtitle']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['pricetype']); ?>&nbsp;</td>
		<td><?php echo $this->Common->removeHtml($course['Course']['summary']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['created']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['name']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'gettingstarted', $course['Course']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete # %s?', $course['Course']['id'])); ?>
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
</div>
