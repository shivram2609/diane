<div class="emailtemplates index">
	<?php echo $this->Form->create("Order",array("div"=>false)); ?>
	<?php echo $this->element("admins/common",array("place"=>'Search by payment ref',"flag"=>false,"pageheader"=>'Transactions',"buttontitle"=>'no',"listflag"=>true,"action"=>"no","selflag"=>false)); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!-- <th><?php //echo $this->Form->input("check",array("label"=>false,"div"=>false,"id"=>'checkall',"type"=>'checkbox')); ?></th>-->
			<th class="leftalign"><?php echo $this->Paginator->sort('id');?></th>
			<th class="leftalign">Course</th>
			<th class="leftalign">Payment From</th>
			<th class="leftalign">Payment To</th>
			<th class="leftalign">Amount (In USD)</th>
			<th class="leftalign">Payment Ref</th>
			<th class="leftalign">Action</th>
	</tr>
	<?php
	$i = 0;
	foreach ($orders as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
		<!-- <td><?php //echo $this->Form->input("id.".$cmsemail['Cmsemail']['id'],array("class"=>'chk',"value"=>$cmsemail['Cmsemail']['id'],"type"=>'checkbox',"div"=>false,"label"=>false)); ?><?php //echo $this->Form->input("status.".$cmsemail['Cmsemail']['id'],array("type"=>'hidden',"value"=>($cmsemail['Cmsemail']['status'] == 1?0:1))); ?></td>-->
		<td class="leftalign"><?php echo h($order['Order']['id']); ?>&nbsp;</td>
		<td class="leftalign"><a href="<?php echo $this->Html->url("/c/".$order['Course']['id']."/".$this->Common->makeurl($order['Course']['title'])); ?>" target="_blank"><?php echo h($order['Course']['title']); ?></a>&nbsp;</td>
		<td class="leftalign"><?php echo h(!empty($order['Order']['buyer_id'])?$order['Buyer']['first_name'].' '.$order['Buyer']['last_name']:"1337 IOT"); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h(!empty($order['Order']['seller_id'])?$order['Seller']['first_name'].' '.$order['Seller']['last_name']:"1337 IOT"); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h(number_format($order['Order']['payment'],"2",".",",")); ?>&nbsp;</td>
		<td class="leftalign"><?php echo h($order['Order']['paymentref']); ?>&nbsp;</td>
		<td class="leftalign"><a href="<?php echo $this->Html->url("/admin/orders/viewtransaction/".$order['Order']['id']) ?>">View Detail</a>&nbsp;</td>
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
