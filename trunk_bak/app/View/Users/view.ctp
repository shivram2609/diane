<div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Remembertoken'); ?></dt>
		<dd>
			<?php echo h($user['User']['remembertoken']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($user['User']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($user['User']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Passwordstatus'); ?></dt>
		<dd>
			<?php echo h($user['User']['passwordstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookmarks'), array('controller' => 'bookmarks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookmark'), array('controller' => 'bookmarks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Testimonials'), array('controller' => 'testimonials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Testimonial'), array('controller' => 'testimonials', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Userdetails'), array('controller' => 'userdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Userdetail'), array('controller' => 'userdetails', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Bookmarks'); ?></h3>
	<?php if (!empty($user['Bookmark'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Campaign Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Bookmark'] as $bookmark): ?>
		<tr>
			<td><?php echo $bookmark['id']; ?></td>
			<td><?php echo $bookmark['campaign_id']; ?></td>
			<td><?php echo $bookmark['user_id']; ?></td>
			<td><?php echo $bookmark['created']; ?></td>
			<td><?php echo $bookmark['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bookmarks', 'action' => 'view', $bookmark['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bookmarks', 'action' => 'edit', $bookmark['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bookmarks', 'action' => 'delete', $bookmark['id']), null, __('Are you sure you want to delete # %s?', $bookmark['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookmark'), array('controller' => 'bookmarks', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Testimonials'); ?></h3>
	<?php if (!empty($user['Testimonial'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Heading'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Testimonial'] as $testimonial): ?>
		<tr>
			<td><?php echo $testimonial['id']; ?></td>
			<td><?php echo $testimonial['user_id']; ?></td>
			<td><?php echo $testimonial['heading']; ?></td>
			<td><?php echo $testimonial['description']; ?></td>
			<td><?php echo $testimonial['status']; ?></td>
			<td><?php echo $testimonial['created']; ?></td>
			<td><?php echo $testimonial['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'testimonials', 'action' => 'view', $testimonial['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'testimonials', 'action' => 'edit', $testimonial['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'testimonials', 'action' => 'delete', $testimonial['id']), null, __('Are you sure you want to delete # %s?', $testimonial['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Testimonial'), array('controller' => 'testimonials', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Userdetails'); ?></h3>
	<?php if (!empty($user['Userdetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('About'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('Country'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Userdetail'] as $userdetail): ?>
		<tr>
			<td><?php echo $userdetail['id']; ?></td>
			<td><?php echo $userdetail['user_id']; ?></td>
			<td><?php echo $userdetail['first_name']; ?></td>
			<td><?php echo $userdetail['last_name']; ?></td>
			<td><?php echo $userdetail['about']; ?></td>
			<td><?php echo $userdetail['city']; ?></td>
			<td><?php echo $userdetail['state']; ?></td>
			<td><?php echo $userdetail['country']; ?></td>
			<td><?php echo $userdetail['image']; ?></td>
			<td><?php echo $userdetail['status']; ?></td>
			<td><?php echo $userdetail['created']; ?></td>
			<td><?php echo $userdetail['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'userdetails', 'action' => 'view', $userdetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'userdetails', 'action' => 'edit', $userdetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'userdetails', 'action' => 'delete', $userdetail['id']), null, __('Are you sure you want to delete # %s?', $userdetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Userdetail'), array('controller' => 'userdetails', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
