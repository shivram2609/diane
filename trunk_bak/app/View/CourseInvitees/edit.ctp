<div class="courseInvitees form">
<?php echo $this->Form->create('CourseInvitee'); ?>
	<fieldset>
		<legend><?php echo __('Edit Course Invitee'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('invitee');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CourseInvitee.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CourseInvitee.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Invitees'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
