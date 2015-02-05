<div class="languages form">
<?php echo $this->Form->create('Language'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Language'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('status');
	?>
	<span style="font-size:10px; font-style:italic">By checking the status box, this language will be available for frontend users</span>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
