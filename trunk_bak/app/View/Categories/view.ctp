<div class="categories view">
<h2><?php  echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($category['Category']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($category['Category']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($category['Category']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($category['Category']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Courses'); ?></h3>
	<?php if (!empty($category['Course'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Language Id'); ?></th>
		<th><?php echo __('Instruction Level Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Subtitle'); ?></th>
		<th><?php echo __('Keywords'); ?></th>
		<th><?php echo __('Summary'); ?></th>
		<th><?php echo __('Coverimage'); ?></th>
		<th><?php echo __('Promovideo'); ?></th>
		<th><?php echo __('Visibility'); ?></th>
		<th><?php echo __('Pricetype'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Privacy Type'); ?></th>
		<th><?php echo __('Publishstatus'); ?></th>
		<th><?php echo __('Adminstatus'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['Course'] as $course): ?>
		<tr>
			<td><?php echo $course['id']; ?></td>
			<td><?php echo $course['user_id']; ?></td>
			<td><?php echo $course['category_id']; ?></td>
			<td><?php echo $course['language_id']; ?></td>
			<td><?php echo $course['instruction_level_id']; ?></td>
			<td><?php echo $course['title']; ?></td>
			<td><?php echo $course['subtitle']; ?></td>
			<td><?php echo $course['keywords']; ?></td>
			<td><?php echo $course['summary']; ?></td>
			<td><?php echo $course['coverimage']; ?></td>
			<td><?php echo $course['promovideo']; ?></td>
			<td><?php echo $course['visibility']; ?></td>
			<td><?php echo $course['pricetype']; ?></td>
			<td><?php echo $course['price']; ?></td>
			<td><?php echo $course['privacy_type']; ?></td>
			<td><?php echo $course['publishstatus']; ?></td>
			<td><?php echo $course['adminstatus']; ?></td>
			<td><?php echo $course['created']; ?></td>
			<td><?php echo $course['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'courses', 'action' => 'view', $course['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, __('Are you sure you want to delete # %s?', $course['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
