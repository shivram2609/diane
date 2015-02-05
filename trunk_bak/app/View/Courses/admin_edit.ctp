<div class="languages form">
<?php echo $this->Form->create('Course'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Course'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('pricetype',array("options"=>array("Paid"=>"Paid","Free"=>"Free")));
		echo $this->Form->input('price',array("type"=>"text"));
		echo $this->Form->input('Userdetail.paypalaccount',array("type"=>"text","value"=>$paypal));
		echo $this->Form->input('Userdetail.user_id',array("type"=>"hidden","value"=>$user_id));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
