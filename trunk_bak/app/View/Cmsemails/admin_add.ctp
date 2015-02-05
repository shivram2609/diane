<?php echo $this->element("admins/common",array("place"=>'Search by title,content',"flag"=>false,"pageheader"=>'',"buttontitle"=>'Add Book',"listflag"=>false)); ?>
<div class="emailtemplates form">
<?php echo $this->Form->create('Cmsemail');?>
	<fieldset>
		<legend><?php echo __('Add Template'); ?></legend>
	<?php
		echo $this->Form->input('mailfrom',array("label"=>"Mail From"));
		echo $this->Form->input('mailsubject',array("label"=>"Mail Subject"));
		echo $this->Form->input('mailcontent',array("label"=>"Mail Content"));
		echo $this->Fck->load('CmsemailMailcontent');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true)); echo $this->Html->link(__('Cancel', true), array('action' => 'index'),array('class'=>'cancel-back-button')); ?>
</div>

