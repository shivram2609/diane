<div class="emailtemplates index">
	<?php echo $this->Form->create("Cmsemail",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by mail subject',"flag"=>false,"pageheader"=>'Email Templates',"buttontitle"=>'no',"listflag"=>true,"action"=>"no","selflag"=>false)); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!-- <th><?php //echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>-->
			<th class="leftalign"><?php echo $this->Paginator->sort('id');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('mailfrom',"Mail From");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('mailsubject',"Mail Subject");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('mailcontent',"Mail Content");?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($cmsemails as $cmsemail):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
		<!-- <td><?php //echo $this->Form->input("id.".$cmsemail['Cmsemail']['id'],array("class"=>'chk',"value"=>$cmsemail['Cmsemail']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php //echo $this->Form->input("status.".$cmsemail['Cmsemail']['id'],array("type"=>'hidden',"value"=>($cmsemail['Cmsemail']['status'] == 1?0:1))); ?></td>-->
		<td class="leftalign"><?php echo h($cmsemail['Cmsemail']['id']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($cmsemail['Cmsemail']['mailfrom']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($cmsemail['Cmsemail']['mailsubject']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo $this->Common->removehtml($cmsemail['Cmsemail']['mailcontent']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cmsemail['Cmsemail']['id'])); ?>
			<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cmsemail['Cmsemail']['id']), null, __('Are you sure you want to delete this template?', $cmsemail['Cmsemail']['id'])); ?>
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
