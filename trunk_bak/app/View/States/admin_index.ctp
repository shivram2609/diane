<div class="states index">
	<?php echo $this->Form->create("State",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'States',"buttontitle"=>'Add State',"listflag"=>true,"action"=>"admin_add")); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('id');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort("Country.name",'Country Name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort("State.name",'Name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('code');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($states as $state):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Form->input("id.".$state['State']['id'],array("class"=>'chk',"value"=>$state['State']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php echo $this->Form->input("status.".$state['State']['id'],array("type"=>'hidden',"value"=>($state['State']['status'] == 1?0:1))); ?></td>
		<td class="leftalign"><?php echo $state['State']['id']; ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($state['Country']['name']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($state['State']['name']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($state['State']['code']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo ($state['State']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
		<td class="actions">
			<?php // echo $this->Html->link(__('View', true), array('action' => 'view', $state['State']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $state['State']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $state['State']['id']), null, __('Are you sure you want to delete this state?', $state['State']['id'])); ?>
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
<?php 
//echo $this->element("changestatus");
echo $this->Form->end(); ?>
