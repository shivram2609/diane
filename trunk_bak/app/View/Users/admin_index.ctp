<div class="users index">
	<?php echo $this->Form->create("User",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by Username',"flag"=>false,"pageheader"=>"Users","buttontitle"=>'no',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th class="leftalign">Name</th>
			<th class="leftalign"><?php echo $this->Paginator->sort('username'); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo $this->Form->input("id.".$user['User']['id'],array("class"=>'chk',"value"=>$user['User']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php echo $this->Form->input("status.".$user['User']['id'],array("type"=>'hidden',"value"=>($user['User']['status'] == 1?0:1))); ?></td>
		<td class="leftalign"><?php echo h($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($user['User']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($user['User']['created']); ?>&nbsp;</td>
		<td class="actions">
			<a href="<?php echo SITE_LINK."profile/".$user['User']['id']."/".$this->Common->makeurl($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']) ?>"
			<?php echo $this->Html->link("Profile",array("controller"=>"profile","action"=>$this->Session->read("Auth.User.Userdetail.user_id"),$this->Common->makeurl($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name'])),array("target"=>"_blank")); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete user %s?', $user['User']['username'])); ?>
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
