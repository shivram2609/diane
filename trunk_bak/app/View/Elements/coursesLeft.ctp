<?php $courseId = $this->data['Course']['id'];?>
<?php echo $this->Session->flash();?>
<div class="pub-pre-box">
		<span class="comp-img ">
			<?php 
				// use thumb path from helper
				$courseImgPathThumb1 = ((!empty($this->data['Course']['coverimage']) && file_exists(WWW_ROOT.$this->data['Course']['coverimage'])) ?$this->data['Course']['coverimage']: "/img/no-img.png");
				$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
				echo $this->Html->image($courseImgThumb1,array("alt"=>$this->data['Course']['title'],"width"=>"110","height"=>"60px"));
				
				?>
		</span>
		<div class="comp-txt">
			<h3><?php echo $userdetails['Course']['title'];?></h3>
			By <a href="<?php echo $this->Html->url("/profile/".$userdetails['Course']['user_id']."/".$this->Common->makeurl($usernames)); ?>" target="_blank" title="<?php echo $usernames;?>"><?php echo ucwords($userdetails['Course']['designation']);?> <?php echo ucwords($userdetails['Course']['name']);?></a>
		</div>
		<div class="pub-pre-box-rt">
			<?php
				if($userdetails['Course']['user_id'] == $this->Session->read('Auth.User.id')){  ?>
				<span class="btn-pub">
					<?php
						if($userdetails['Course']['publishstatus'] == 'Publish') { 
							echo $this->Html->link("Unpublish",array("controller"=>"course-manage","action"=>"unpublish",$userdetails['Course']['id']), null, __('Are you sure you want to unpublish course %s?',$userdetails['Course']['title']));
						} else {
							echo $this->Html->link("Publish",array("controller"=>"course-manage","action"=>"publish",$userdetails['Course']['id']));
							//echo "Your course is not published yet. In the future, you can unpublish your course here!";
						}
					?>
				</span>
				<?php } ?>
			<span class="btn-pre acc_drpdwn1" ><a class="img" href="Javascript:void(0);">Preview</a>
				<div class="preview_btn" style="display:none;">
					<div class="top-arrow"></div>
					<div class="bdr-top">
						<ul>
							<li><a href="<?php echo $this->Html->url("/i/".$userdetails['Course']['id']."/".$this->Common->makeurl($userdetails['Course']['title'])); ?>" title="As Instructor">As Instructor </a></li>
							<li><a href="<?php echo $this->Html->url("/s/".$userdetails['Course']['id']."/".$this->Common->makeurl($userdetails['Course']['title'])); ?>" title="As Student">As Student</a></li>
							<li><a href="<?php echo $this->Html->url("/g/".$userdetails['Course']['id']."/".$this->Common->makeurl($userdetails['Course']['title'])); ?>" title="As Guest">As Guest</a></li>
						</ul>
					</div>
				</div>
			</span>
		</div>
	</div>

<aside class="left-container2">
<div class="left-bar">
	<h2>Course Content</h2>
	<ul>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'editcurriculum') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/syllabus/'.$courseId);?>" title="Curriculum">Syllabus</a></li>
		<?php /*<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'livesession') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/session/'.$courseId);?>" title="Live Sessions ">Live Sessions </a></li><?php */?>
	</ul>
	<h2>Course Info</h2>
	<ul>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'basic') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/introduction/'.$courseId);?>" title="Inroduction">Introduction</a></li>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'details') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/course-summary/'.$courseId);?>" title="Course Summary">Course Summary</a></li>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'coverimage') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/cover-image/'.$courseId);?>" title="Cover Image">Cover Image</a></li>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'promovideo') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/promo-video/'.$courseId);?>" title="Promo Video">Promo Video</a></li>
	</ul>
	<h2>COURSE SETTINGS</h2>
	<ul>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'privacy') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/privacy/'.$courseId);?>" title="Privacy Level">Privacy Level</a></li>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'price') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/price/'.$courseId);?>" title="Price &amp; Coupons">Price</a></li>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'instructors') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/instructors/'.$courseId);?>" title="Manage Instructors">Instructor Permissions</a></li>
		
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'dangerzone') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Danger Zone">Delete Course</a></li>
	</ul>
	<h2></h2>
	<ul>
		<li  class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'gettingstarted') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/guidelines/'.$courseId);?>" title="Getting Started">Course Guidelines</a></li>
		
	</ul>
</div>
</aside>

<div class="mobile-nav">
Course Content
<ul>
		<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'editcurriculum') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/syllabus/'.$courseId);?>" title="Curriculum">Syllabus</a></li>
		<li class="acc_drpdwn2"><a href="javascript:void(0);" title="Course Info">Course Info</a>
			<ul class="nav_btn1" style="display:none;">
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'basic') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/introduction/'.$courseId);?>" title="Inroduction">Introduction</a></li>
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'details') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/course-summary/'.$courseId);?>" title="Course Summary">Course Summary</a></li>
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'coverimage') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/cover-image/'.$courseId);?>" title="Cover Image">Cover Image</a></li>
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'promovideo') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/promo-video/'.$courseId);?>" title="Promo Video">Promo Video</a></li>
			</ul>
		</li>
		<li class="acc_drpdwn3"><a href="javascript:void(0);" title="Course Settings">SETTINGS</a>
			<ul class="nav_btn2" style="display:none;">
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'privacy') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/privacy/'.$courseId);?>" title="Privacy Level">Privacy Level</a></li>
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'price') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/price/'.$courseId);?>" title="Price &amp; Coupons">Price</a></li>
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'instructors') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/instructors/'.$courseId);?>" title="Manage Instructors">Instructor Permissions</a></li>
				
				<li class="<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'dangerzone') echo  'selected'?>"><a href="<?php echo $this->HTML->url('/course-manage/delete-course/'.$courseId);?>" title="Danger Zone">Delete Course</a></li>
			</ul>
		</li>
	</ul>
</div>