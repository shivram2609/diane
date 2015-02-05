<div class="coursePasswords form">
<?php echo $this->Form->create('CoursePassword'); ?>
	<fieldset>
		<legend><?php echo __('Edit Course Password'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('password');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CoursePassword.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CoursePassword.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Passwords'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
