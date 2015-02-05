<div class="admindetails form">
<?php echo $this->Form->create('Admindetail'); ?>
	<fieldset>
		<legend><?php echo __('Edit Admindetail'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('admin_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('country');
		echo $this->Form->input('zip');
		echo $this->Form->input('address');
		echo $this->Form->input('company');
		echo $this->Form->input('company_logo');
		echo $this->Form->input('signature');
		echo $this->Form->input('image');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Admindetail.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Admindetail.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Admindetails'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Admins'), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin'), array('controller' => 'admins', 'action' => 'add')); ?> </li>
	</ul>
</div>
