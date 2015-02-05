<?php echo $this->element("admins/common",array("place"=>'Search by title,content',"flag"=>false,"pageheader"=>'',"buttontitle"=>'Add Book',"listflag"=>false)); ?>
<div class="countries form">
<?php echo $this->Form->create('Country');?>
	<fieldset>
 		<legend><?php echo __('Add Country'); ?></legend>
	<?php
		echo $this->Form->input('name',array("label"=>"Country Name"));
		echo $this->Form->input('code',array("label"=>"Country Code"));
		echo $this->Form->input('status',array("label"=>"Active","type"=>'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true)); echo $this->Html->link(__('Cancel', true), array('action' => 'index'),array('class'=>'cancel-back-button'));?>
</div>
