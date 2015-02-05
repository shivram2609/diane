<div class="cmsemails form">
<?php echo $this->Form->create('Cmsemail'); ?>
	<fieldset>
		<legend><?php echo __('Add Cmsemail'); ?></legend>
	<?php
		echo $this->Form->input('mailfrom');
		echo $this->Form->input('mailsubject');
		echo $this->Form->input('mailcontent');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cmsemails'), array('action' => 'index')); ?></li>
	</ul>
</div>
