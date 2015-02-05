<div class="courseRequirements view">
<h2><?php  echo __('Course Requirement'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($courseRequirement['CourseRequirement']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseRequirement['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseRequirement['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($courseRequirement['CourseRequirement']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseRequirement['CourseRequirement']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseRequirement['CourseRequirement']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Requirement'), array('action' => 'edit', $courseRequirement['CourseRequirement']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Requirement'), array('action' => 'delete', $courseRequirement['CourseRequirement']['id']), null, __('Are you sure you want to delete # %s?', $courseRequirement['CourseRequirement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Requirements'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Requirement'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
