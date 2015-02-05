<div class="countries index">
	<?php echo $this->Form->create("Country",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by country name',"flag"=>false,"pageheader"=>'Countries',"buttontitle"=>'Add Country',"listflag"=>true,"action"=>"admin_add")); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('code');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($countries as $country):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Form->input("id.".$country['Country']['id'],array("class"=>'chk',"value"=>$country['Country']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php echo $this->Form->input("status.".$country['Country']['id'],array("type"=>'hidden',"value"=>($country['Country']['status'] == 1?0:1))); ?></td>
		<td class="leftalign"><?php echo substr(strip_tags($country['Country']['name']),0,200); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($country['Country']['code']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo ($country['Country']['status']==1?'Active':'Inactive'); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $country['Country']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $country['Country']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $country['Country']['id']), null, __('Are you sure you want to delete this country?', $country['Country']['id'])); ?>
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
