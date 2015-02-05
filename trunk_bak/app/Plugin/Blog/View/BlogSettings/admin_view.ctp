<div class="blogSettings view">
	<div class="rhs_actions2" style="float:right;">
		<?php echo $this->Html->link(__('Edit Blog Setting'), array('action' => 'edit', $blogSetting['BlogSetting']['id'])); ?>
		<?php echo $this->Html->link(__('List Blog Settings'), array('action' => 'index')); ?> 
</div>
<h2><?php  echo __('Blog Setting');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($blogSetting['BlogSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Setting'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($blogSetting['BlogSetting']['setting']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($blogSetting['BlogSetting']['value']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($blogSetting['BlogSetting']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

