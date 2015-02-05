<div class="courseAudiences index">
	<h2><?php echo __('Course Audiences'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('course_id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($courseAudiences as $courseAudience): ?>
	<tr>
		<td><?php echo h($courseAudience['CourseAudience']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseAudience['Course']['title'], array('controller' => 'courses', 'action' => 'view', $courseAudience['Course']['id'])); ?>
		</td>
		<td><?php echo h($courseAudience['CourseAudience']['title']); ?>&nbsp;</td>
		<td><?php echo h($courseAudience['CourseAudience']['created']); ?>&nbsp;</td>
		<td><?php echo h($courseAudience['CourseAudience']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $courseAudience['CourseAudience']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $courseAudience['CourseAudience']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $courseAudience['CourseAudience']['id']), null, __('Are you sure you want to delete # %s?', $courseAudience['CourseAudience']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Course Audience'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
