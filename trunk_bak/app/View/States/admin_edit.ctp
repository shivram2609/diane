<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'',"buttontitle"=>'Add State',"listflag"=>false)); ?>
<div class="states form">
<?php echo $this->Form->create('State');?>
	<fieldset>
 		<legend><?php echo __('Edit State'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('country_id');
		echo $this->Form->input('name',array("label"=>"State Name"));
		echo $this->Form->input('code');
		echo $this->Form->input('status',array("label"=>"Active","type"=>"checkbox"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true)); echo $this->Html->link(__('Cancel', true), array('action' => 'index'),array('class'=>'cancel-back-button')); ?>
</div>
