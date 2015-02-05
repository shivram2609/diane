<div class="blogPosts form">
<?php echo $this->Form->create('BlogPost');?>
	<fieldset>
		<legend><?php __('Add Blog Post'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('slug');
		echo $this->Form->input('summary');
		echo $this->Form->input('body');
		echo $this->Form->input('published');
		echo $this->Form->input('sticky');
		echo $this->Form->input('meta_title');
		echo $this->Form->input('meta_description');
		echo $this->Form->input('meta_keywords');
		echo $this->Form->input('BlogPostCategory');
		echo $this->Form->input('BlogPostTag');
	?>
	</fieldset>
	<?php echo $this->Fck->load('BlogPostBody'); ?>
<?php echo $this->Form->end(__('Submit'));?>
</div>
