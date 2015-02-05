<div class="pages index">
	<?php echo $this->Form->create("Cmspage",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by title,content',"flag"=>false,"pageheader"=>'Pages',"buttontitle"=>'Add Page',"listflag"=>true,"action"=>'admin_add')); ?>
	<table cellpadding="0" cellspacing="0" style="margin-top:30px">
	<tr>
			<th><?php echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('id');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('name');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('content');?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('metatitle',"Meta Title");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('seourl',"Seo Url");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('metadesc',"Meta Description");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('metakeyword',"Meta Keyword");?></th>
			<th class="leftalign"><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($cmspages as $cmspage): 
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo ($cmspage['Cmspage']['id'])?($this->Form->input("id.".$cmspage['Cmspage']['id'],array("class"=>'chk',"value"=>$cmspage['Cmspage']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)).$this->Form->input("status.".$cmspage['Cmspage']['id'],array("type"=>'hidden',"value"=>($cmspage['Cmspage']['status'] == 1?0:1)))):'&nbsp;'; ?></td>
		<td class="leftalign"><?php echo h($cmspage['Cmspage']['id']); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($this->Common->removehtml($cmspage['Cmspage']['name'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo ($this->Common->removehtml($cmspage['Cmspage']['content'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($this->Common->removehtml($cmspage['Cmspage']['metatitle'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($this->Common->removehtml($cmspage['Cmspage']['seourl'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($this->Common->removehtml($cmspage['Cmspage']['metadesc'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($this->Common->removehtml($cmspage['Cmspage']['metakeyword'])); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h(($cmspage['Cmspage']['status'] == 1)?'Active':'Inactive'); ?>&nbsp;</td>
		<td class="actions" style="text-align:center">
			<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $cmspage['Cmspage']['id'])); ?>
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
<?php //echo $this->element("changestatus"); ?> 
<?php
echo $this->Form->end(); ?>
