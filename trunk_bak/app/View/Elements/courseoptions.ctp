<div>&nbsp;</div>
<div class="profile_header">
	<h2 class="heading4"><?php echo($this->data['Course']['title']."</h2> added by ".$this->Session->read("Auth.User.Userdetail.first_name")." ".$this->Session->read("Auth.User.Userdetail.last_name")); ?>
</div>
<div>&nbsp;</div>
<div class="profile_header">
	<h2 class="heading4">
		COURSE CONTENT
		<ul>
			<li><a href="<?php echo $this->Html->url("/course-manage/edit-curriculum/".$this->data['Course']['id']); ?>">Curriculum</a></li>
			<?php if($this->data['Course']['publishstatus'] == 'Unpublish') { ?>
				<li><a href="<?php echo $this->Html->url("/course-manage/publish/".$this->data['Course']['id']); ?>">Publish</a></li>
			<?php } ?>
		</ul>
	</h2>
	<h2 class="heading4">
		COURSE INFO
		<ul>
			<li><a href="<?php echo $this->Html->url("/course-manage/basic/".$this->data['Course']['id']); ?>">Basics</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/details/".$this->data['Course']['id']); ?>">Details</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/cover-image/".$this->data['Course']['id']); ?>">Cover Image</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/promo-video/".$this->data['Course']['id']); ?>">Promo Video</a></li>
		</ul>
	</h2>
	<h2 class="heading4">
		COURSE SETTINGS
		<ul>
			<li><a href="<?php echo $this->Html->url("/course-manage/privacy/".$this->data['Course']['id']); ?>">Privacy</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/price/".$this->data['Course']['id']); ?>">Price</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/instructors/".$this->data['Course']['id']); ?>">Manage Instructors</a></li>
			<li><a href="<?php echo $this->Html->url("/course-manage/danger-zone/".$this->data['Course']['id']); ?>">Danger Zone</a></li>
		</ul>
	</h2>
</div>
