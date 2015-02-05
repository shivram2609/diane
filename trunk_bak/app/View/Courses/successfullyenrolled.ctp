<div class="container">
	<div id="course-enrolled">
		<h1>Course Enrollment Confirmation</h1>
		<div class="outer-cnt">
			<h2>Success</h2>
			<div class="in-content">
			<p>You are successfully enrolled in this course.</p><br>
			<br>
			<?php if(!empty($courselec['CourseLecture']['id'])) { ?>
				<a href="<?php echo $this->Html->url("/v/".$courselec['CourseLecture']['id']."/".$this->Common->makeurl($courselec['CourseLecture']['heading'])); ?>" class="button-1" title="Start Learning">Start Learning</a><br>
			<?php } else { ?>
				<a href="<?php echo $this->Html->url("/mycourses"); ?>" class="button-1" title="Start Learning">Start Learning</a><br>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
