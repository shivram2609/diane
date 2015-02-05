<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'States',"buttontitle"=>'Add State',"listflag"=>false)); ?>
<div class="cities form">
<?php echo $this->Form->create('City');?>
	<fieldset>
 		<legend><?php echo __('Add City'); ?></legend>
	<?php
		echo $this->Form->input('state_id');
		echo $this->Form->input('name',array("label"=>"City Name"));
		echo $this->Form->input('code');
		echo $this->Form->input('status',array("label"=>"Active","type"=>"checkbox"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true)); echo $this->Html->link(__('Cancel', true), array('action' => 'index'),array('class'=>'cancel-back-button')); ?>
</div>
