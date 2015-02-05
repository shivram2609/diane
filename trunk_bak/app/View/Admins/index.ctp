<div class="admins index">
<?php echo $this->Form->create("Admin",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by username,domain',"flag"=>false,"pageheader"=>'Admins',"buttontitle"=>'Add Admin',"listflag"=>true,"action"=>'add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th><?php //echo $this->Paginator->sort('id');?>Sr No</th>
			<th><?php echo $this->Paginator->sort('username',"Username/Email");?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$loggedUser = $this->Session->read("admin");
	foreach ($admins as $admin): 
		$class = null;
		
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $this->Form->input("id.".$admin['Admin']['id'],array("class"=>'chk',"value"=>$admin['Admin']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php echo $this->Form->input("status.".$admin['Admin']['id'],array("type"=>'hidden',"value"=>($admin['Admin']['status'] == 1?0:1))); ?></td>
				<td><?php echo h(empty($admin['Admin']['id'])?'':$i); ?>&nbsp;</td>
				<td><?php echo h($admin['Admin']['username']); ?>&nbsp;</td>
				<td><?php echo ($admin['Admin']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $admin['Admin']['id'])); ?>
					<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $admin['Admin']['id']), null, __('Are you sure you want to delete # %s?', $admin['Admin']['id'])); ?>
				</td>
			</tr>
<?php	
	endforeach; ?>
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
<!--div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New Admin'), array('action' => 'add')); ?></li>
		<li><?php //echo $this->Html->link(__('List Admindetails'), array('controller' => 'admindetails', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Admindetail'), array('controller' => 'admindetails', 'action' => 'add')); ?> </li>
		<li><?php //echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div-->
<?php echo $this->Form->end(); ?>
