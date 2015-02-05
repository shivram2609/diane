<div class="courseInvitees view">
<h2><?php  echo __('Course Invitee'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($courseInvitee['CourseInvitee']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courseInvitee['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseInvitee['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invitee'); ?></dt>
		<dd>
			<?php echo h($courseInvitee['CourseInvitee']['invitee']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($courseInvitee['CourseInvitee']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($courseInvitee['CourseInvitee']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Invitee'), array('action' => 'edit', $courseInvitee['CourseInvitee']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Course Invitee'), array('action' => 'delete', $courseInvitee['CourseInvitee']['id']), null, __('Are you sure you want to delete # %s?', $courseInvitee['CourseInvitee']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Invitees'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Invitee'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
