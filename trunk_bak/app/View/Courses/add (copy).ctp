<div class="profile_section">
	<?php echo $this->Form->create('Userdetail',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Session->flash(); ?>
	<div>&nbsp;</div>
		<div class="profile_header">
			<h2 class="heading4">Create Course</h2>
		</div>
	<div class="profile_detail_bx">
	<span class="pro_fld"><?php echo $this->Form->input('title'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('subtitle'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('summary'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('keywords'); ?></span>
	<span class="pro_fld"><?php echo $this->Form->input('category_id'); ?></span>
	<span class="pro_fld"><?php echo $this->Form->input('language_id'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('coverimage'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('promovideo'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('visibility'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('privacy_type'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('publishstatus'); ?></span>
	<span class="pro_fld"><?php	echo $this->Form->input('adminstatus');	?></span>
	</div>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
