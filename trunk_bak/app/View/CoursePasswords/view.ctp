<div class="coursePasswords view">
<h2><?php  echo __('Course Password'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($coursePassword['CoursePassword']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($coursePassword['Course']['title'], array('controller' => 'courses', 'action' => 'view', $coursePassword['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($coursePassword['CoursePassword']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($coursePassword['CoursePassword']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($coursePassword['CoursePassword']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Password'), array('action' => 'edit', $coursePassword['CoursePassword']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Password'), array('action' => 'delete', $coursePassword['CoursePassword']['id']), null, __('Are you sure you want to delete # %s?', $coursePassword['CoursePassword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Passwords'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Password'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
