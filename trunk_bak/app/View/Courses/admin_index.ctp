<div class="courses index">
	<?php echo $this->Form->create("Course",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by Course',"flag"=>false,"pageheader"=>"Course","buttontitle"=>'no',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('pricetype',"Price"); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($courses as $course): ?>
	<tr>
		<td><?php echo $this->Form->input("id.".$course['Course']['id'],array("class"=>'chk',"value"=>$course['Course']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?></td>
		<td class="leftalign"><?php echo h($course['Course']['title']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
		<td><?php echo h(($course['Course']['pricetype']=='Free' || empty($course['Course']['pricetype'])) ?'Free':$course['Course']['price']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['created']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $course['Course']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete  %s?', $course['Course']['title'])); ?>
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
