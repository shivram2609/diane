<div class="container">
	<div class="sitemap">
		<h1>Institute of Technology <span>Sitemap</span></h1>
		<section class="col">
			<h2>Courses</h2>
			<ul>
				<li><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="All" target="_blank">All</a></li>
				<?php foreach($categories as $key=>$val) { ?>
					<li><a href="<?php echo $this->Html->url("/view-courses/".$this->Common->makeurl($val)."/".$key); ?>" title="<?php echo $val; ?>" target="_blank"><?php echo $val; ?></a></li>
				<?php } ?>
			</ul>
		</section>
		<section class="col">
			<h2>Teach Online</h2>
			<ul>
				<?php if ($this->Session->read("Auth.User.id")) { ?>
					<li><a href="<?php echo $this->Html->url("/course-manage/create"); ?>" title="Create A Course">Create A Course</a></li>
				<?php } else { ?>
					<li><a href="<?php echo $this->Html->url("/login/course-manage/create"); ?>" id="createcourse1" >Create A Course</a></li>
				<?php } ?>
			</ul>
			<h2>My Courses</h2>
			<ul>
				<?php if ($this->Session->read("Auth.User.id")) { ?>
					<li><a href="<?php echo $this->Html->url("/myenrolled"); ?>" title="Enrolled">Enrolled</a><li>
					<li><a href="<?php echo $this->Html->url("/mycompleted"); ?>" title="Completed">Completed</a></li>
					<li><a href="<?php echo $this->Html->url("/mycourses"); ?>" title="Teaching">Teaching</a></li>
				<?php } else { ?>
					<li><a href="<?php echo $this->Html->url("/login/myenrolled"); ?>" id="createcourse12">Enrolled</a><li>
					<li><a href="<?php echo $this->Html->url("/login/mycompleted"); ?>" id="createcourse13">Completed</a></li>
					<li><a href="<?php echo $this->Html->url("/login/mycourses"); ?>" id="createcourse14">Teaching</a></li>
				<?php } ?>
			</ul>
		</section>
		<section class="col-last">
			<h2>Terms of Use</h2>
			<ul>
				<?php foreach($pages as $page): ?>
					<li><a href="<?php echo $this->Html->url("/st/".$page['Cmspages']['seourl']); ?>" title="<?php echo $page['Cmspages']['name'];?>"><?php echo $page['Cmspages']['name'];?></a></li>
				<?php endforeach;?>
				<li><a href="<?php echo $this->Html->url("/contact-us"); ?>" title="Contact Us">Contact Us</a></li>
				<li><a href="<?php echo $this->Html->url("/support"); ?>" title="Support">Support</a></li>
				<li><a href="<?php echo $this->Html->url("/site-map"); ?>" title="Site Map">Site Map</a></li>
			</ul>
		</section>
	</div>
</div>
