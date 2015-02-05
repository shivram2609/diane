<div class="courseInvitees index">
	<h2><?php echo __('Course Invitees'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('course_id'); ?></th>
			<th><?php echo $this->Paginator->sort('invitee'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($courseInvitees as $courseInvitee): ?>
	<tr>
		<td><?php echo h($courseInvitee['CourseInvitee']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseInvitee['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseInvitee['Course']['id'])); ?>
		</td>
		<td><?php echo h($courseInvitee['CourseInvitee']['invitee']); ?>&nbsp;</td>
		<td><?php echo h($courseInvitee['CourseInvitee']['created']); ?>&nbsp;</td>
		<td><?php echo h($courseInvitee['CourseInvitee']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $courseInvitee['CourseInvitee']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $courseInvitee['CourseInvitee']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $courseInvitee['CourseInvitee']['id']), null, __('Are you sure you want to delete # %s?', $courseInvitee['CourseInvitee']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Course Invitee'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
