<?php $courseId = $this->data['Course']['id'];?>
<div class="container">
			<div class="course-guideline">
				<h1>Course Guidelines<br /><br/> <span>Welcome, <span class="txt-bold"><?php echo ucfirst($this->Session->read("Auth.User.Userdetail.first_name")).' '.ucwords($this->Session->read("Auth.User.Userdetail.last_name")); ?></span>!<br />Congratulations on your decision to create an online course at 1337 Institute of Technology.<br />These are just some helpful guidelines to help your course creation be as smooth as possible.</span></h1>
				<div class="contnt-box">
					<a href="<?php echo $this->HTML->url('/course-manage/edit-curriculum/'.$courseId);?>" title="Course Content">
						<strong class="categ-box">
							<span class="heading">Course Content</span>
						</strong>
					</a>	
					<span class="links"><a href="<?php echo $this->HTML->url('/course-manage/syllabus/'.$courseId);?>" title="Syllabus">Syllabus</a></span>
					
					<p><strong>Syllabus:</strong> This is where you create your course outline and add your materials. You can add multiple modules,  lessons and quizzes  </p>
				</div>
				<div class="contnt-box">
					<a href="<?php echo $this->HTML->url('/course-manage/introduction/'.$courseId);?>" title="Course Info">
						<strong class="categ-box">
							<span class="heading">Course Info</span>
						</strong>
					</a>
					<span class="links">
							<a href="<?php echo $this->HTML->url('/course-manage/introduction/'.$courseId);?>" title="Introduction">Introduction</a>, <a href="<?php echo $this->HTML->url('/course-manage/course-summary/'.$courseId);?>" title="Course Summary">Course Summary</a>, <a href="<?php echo $this->HTML->url('/course-manage/cover-image/'.$courseId);?>" title="Cover Image">Cover Image</a>,<br/> <a href="<?php echo $this->HTML->url('/course-manage/promo-video/'.$courseId);?>" title="Promo Video">Promo Video</a>
					</span>
					
					<p><span><strong>Introduction:</strong> This includes the basic elements of your course, eg: Title, subtitle and key words</span>
					<span><strong>Course Summary:</strong> Create your course summary, goals and objectives</span>
					<span><strong>Cover Image:</strong> Upload your course image as a cover preview for your course</span>
					<span><strong>Promo Video:</strong> Upload your 1-2 minute promotional video</span>
					</p>
				</div>
				<div class="contnt-box">
					<a href="<?php echo $this->HTML->url('/course-manage/privacy/'.$courseId);?>" title="Course Settings">
						<strong class="categ-box box-2">
							<span class="heading">Course Settings</span>
						</strong>
					</a>
					<span class="links links-2">
							<a href="<?php echo $this->HTML->url('/course-manage/privacy/'.$courseId);?>" title="Privacy">Privacy Level</a>, <a href="<?php echo $this->HTML->url('/course-manage/price/'.$courseId);?>" title="Price">Price</a>, <a href="<?php echo $this->HTML->url('/course-manage/instructors/'.$courseId);?>" title="Manage Instructors">Instructor Permissions</a>, <br /> <a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Delete Course">Delete Course</a>
					</span>
					
					<p><span><strong>Privacy Level:</strong> These settings allow the course will be viewed, private or public</span>
					<span><strong>Price:</strong> Allows you to set your desired price for the course, or you can offer for free if you like</span>
					<span><strong>Instructor Permissions:</strong> To add additional instructors for the course</span>
					<span><strong>Delete Course: </strong> Unpublish or Remove your course</span>
					</p>
				</div>
				<div class="contnt-box">
					<a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Course Activation">
						<strong class="categ-box">
							<span class="heading">Course Activation</span>
						</strong>
					</a>
						<span class="links">
							<a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Activate Course">Activate Course</a>, <a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Delete Course">Delete Course</a>
						</span>
					
					<p>Upload your materials for the world to see onto our platform!<br /> <br /><strong>Good Luck!</strong></p>
				</div>
				<h3>We will do all we can to help you promote your course. <br />We want you to be successful and to reach as many students as you can.<br />Please reach out to us if there is anything that we can do to help.</h3>
			</div>
		</div>
