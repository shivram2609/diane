<div class="cmspages form">
<?php echo $this->Form->create('Cmspage'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cmspage'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('content');
		echo $this->Form->input('metatitle');
		echo $this->Form->input('seourl');
		echo $this->Form->input('metadesc');
		echo $this->Form->input('metakeyword');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cmspage.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cmspage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cmspages'), array('action' => 'index')); ?></li>
	</ul>
</div>
