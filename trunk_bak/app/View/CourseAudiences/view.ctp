<div class="courseAudiences view">
<h2><?php  echo __('Course Audience'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($courseAudience['CourseAudience']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseAudience['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseAudience['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($courseAudience['CourseAudience']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseAudience['CourseAudience']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseAudience['CourseAudience']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Audience'), array('action' => 'edit', $courseAudience['CourseAudience']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Audience'), array('action' => 'delete', $courseAudience['CourseAudience']['id']), null, __('Are you sure you want to delete # %s?', $courseAudience['CourseAudience']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Audiences'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Audience'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
