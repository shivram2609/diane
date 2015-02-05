<div class="courseGoals view">
<h2><?php  echo __('Course Goal'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($courseGoal['CourseGoal']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseGoal['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseGoal['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($courseGoal['CourseGoal']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseGoal['CourseGoal']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseGoal['CourseGoal']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Goal'), array('action' => 'edit', $courseGoal['CourseGoal']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Goal'), array('action' => 'delete', $courseGoal['CourseGoal']['id']), null, __('Are you sure you want to delete # %s?', $courseGoal['CourseGoal']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Goals'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Goal'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
