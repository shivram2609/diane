<div class="cities index">
	<?php echo $this->Form->create("City",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by city name or state name',"flag"=>false,"pageheader"=>'Cities',"buttontitle"=>'Add City',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('id');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort("State.name",'State Name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort("City.name",'Name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('code');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($cities as $city):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Form->input("id.".$city['City']['id'],array("class"=>'chk',"value"=>$city['City']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php echo $this->Form->input("status.".$city['City']['id'],array("type"=>'hidden',"value"=>($city['City']['status'] == 1?0:1))); ?></td>
		<td class="leftalign"><?php echo $city['City']['id']; ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($city['State']['name']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($city['City']['name']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo substr(strip_tags($city['City']['code']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo ($city['City']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $city['City']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $city['City']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $city['City']['id']), null, __('Are you sure you want to delete %s?', $city['City']['name'])); ?>
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
