<div class="backupdbs index">
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Generate Backup'), array('action' => 'add')); ?></li>
		</ul>
	</div>
	<?php echo $this->Form->create("Backupdb",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by Database',"flag"=>false,"database"=>true,"pageheader"=>"Backupdbs","buttontitle"=>'no',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th><?php echo $this->Paginator->sort('filename'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($backupdbs as $backupdb): ?>
	<tr>
		<td><?php echo $this->Form->input("id.".$backupdb['Backupdb']['id'],array("class"=>'chk',"value"=>$backupdb['Backupdb']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?></td>
		<td><?php echo $this->Html->link($backupdb['Backupdb']['filename'], array('action' => 'download', $backupdb['Backupdb']['filename'])); ?>&nbsp;</td>
		<td><?php echo h($backupdb['Backupdb']['created']); ?>&nbsp;</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $backupdb['Backupdb']['id'], $backupdb['Backupdb']['filename'] ), null, __('Are you sure you want to delete # %s?', $backupdb['Backupdb']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end(); ?>
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
