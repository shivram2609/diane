<div class="blogPosts index">
	<div class="rhs_actions2" style="float:right;">
	<?php echo $this->Html->link(__('New Blog Post'), array('action' => 'add')); ?></li>
		<?php echo $this->Html->link(__('List Blog Post Categories'), array('controller' => 'blog_post_categories', 'action' => 'index')); ?> 
		<?php echo $this->Html->link(__('New Blog Post Category'), array('controller' => 'blog_post_categories', 'action' => 'add')); ?>
		<?php echo $this->Html->link(__('List Blog Post Tags'), array('controller' => 'blog_post_tags', 'action' => 'index')); ?>
		<?php echo $this->Html->link(__('New Blog Post Tag'), array('controller' => 'blog_post_tags', 'action' => 'add')); ?> 
</div>
	<h2><?php echo __('Blog Posts');?></h2>
	<?php echo $this->Session->flash(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('published');?></th>
			<th><?php echo $this->Paginator->sort('sticky');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($blogPosts as $blogPost):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo h($blogPost['BlogPost']['id']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['title']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['slug']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['published'] == 1?"Published":"Unpublished"); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['sticky'] == 1?"Yes":"No"); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['created']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<a href="<?php echo $this->Html->url("/admin/blog/blog_posts/view/".$blogPost['BlogPost']['id']); ?>">View</a>
			<a href="<?php echo $this->Html->url("/admin/blog/blog_posts/edit/".$blogPost['BlogPost']['id']); ?>">Edit</a>
			<a href="<?php echo $this->Html->url("/admin/blog/blog_posts/delete/".$blogPost['BlogPost']['id']); ?>" onclick="return confirm('Are you sure you want to delete this post?')" >Delete</a>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>

