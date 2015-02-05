<div class="categories index">
	<?php echo $this->Form->create("Category",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by Category',"flag"=>false,"pageheader"=>"Categories","buttontitle"=>'no',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($categories as $category): ?>
	<tr>
		<td><?php echo $this->Form->input("id.".$category['Category']['id'],array("class"=>'chk',"value"=>$category['Category']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?></td>
		<td><?php echo h($category['Category']['title']); ?>&nbsp;</td>
		<td><?php echo h($category['Category']['status']==1?'Active':'Inactive'); ?> &nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete category %s?', $category['Category']['title'])); ?>
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
<?php echo $this->Form->end(); ?>
