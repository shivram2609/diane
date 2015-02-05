<div class="courseInstructors view">
<h2><?php  echo __('Course Instructor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($courseInstructor['CourseInstructor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseInstructor['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseInstructor['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseInstructor['User']['id'], array('controller' => 'users', 'action' => 'view', $courseInstructor['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Editpermission'); ?></dt>
		<dd>
			<?php echo h($courseInstructor['CourseInstructor']['editpermission']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseInstructor['CourseInstructor']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseInstructor['CourseInstructor']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Instructor'), array('action' => 'edit', $courseInstructor['CourseInstructor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Instructor'), array('action' => 'delete', $courseInstructor['CourseInstructor']['id']), null, __('Are you sure you want to delete # %s?', $courseInstructor['CourseInstructor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Instructors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Instructor'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
