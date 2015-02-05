<div class="cmspages index">
	<h2><?php echo __('Cmspages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th><?php echo $this->Paginator->sort('metatitle'); ?></th>
			<th><?php echo $this->Paginator->sort('seourl'); ?></th>
			<th><?php echo $this->Paginator->sort('metadesc'); ?></th>
			<th><?php echo $this->Paginator->sort('metakeyword'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($cmspages as $cmspage): ?>
	<tr>
		<td><?php echo h($cmspage['Cmspage']['id']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['name']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['content']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['metatitle']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['seourl']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['metadesc']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['metakeyword']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['status']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['created']); ?>&nbsp;</td>
		<td><?php echo h($cmspage['Cmspage']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cmspage['Cmspage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cmspage['Cmspage']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cmspage['Cmspage']['id']), null, __('Are you sure you want to delete # %s?', $cmspage['Cmspage']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Cmspage'), array('action' => 'add')); ?></li>
	</ul>
</div>
