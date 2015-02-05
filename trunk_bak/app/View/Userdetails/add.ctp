<div class="userdetails form">
<?php echo $this->Form->create('Userdetail'); ?>
	<fieldset>
		<legend><?php echo __('Add Userdetail'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('about');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('country');
		echo $this->Form->input('image');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Userdetails'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
