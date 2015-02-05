<div class="admindetails view">
<h2><?php  echo __('Admindetail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Admin'); ?></dt>
		<dd>
			<?php echo $this->Html->link($admindetail['Admin']['id'], array('controller' => 'admins', 'action' => 'view', $admindetail['Admin']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['company']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company Logo'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['company_logo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Signature'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['signature']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($admindetail['Admindetail']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Admindetail'), array('action' => 'edit', $admindetail['Admindetail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Admindetail'), array('action' => 'delete', $admindetail['Admindetail']['id']), null, __('Are you sure you want to delete # %s?', $admindetail['Admindetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Admindetails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admindetail'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Admins'), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin'), array('controller' => 'admins', 'action' => 'add')); ?> </li>
	</ul>
</div>
