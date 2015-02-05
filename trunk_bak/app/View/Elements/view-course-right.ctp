<!--====View course Right Panel Sart====-->
			<div id="view-course-rt">
<!--====View course Instructors Sart====-->
				<div class="instructors">	
					<!--<h3>Instructors</h3>-->
					<div class="contnt">
						<div class="img">
							
							<?php 
							// use thumb path from helper
							$ProfileImgPathThumb1 = ((!empty($user['Userdetail']['image']) && file_exists(WWW_ROOT.$user['Userdetail']['image']))?$user['Userdetail']['image']: "/img/no-img.png");
							$ProfileImgThumb1 = $this->Common->getImageName($ProfileImgPathThumb1, SmallImageProfilePrefix);
							echo $this->Html->image($ProfileImgThumb1,array("alt"=>$username,"width"=>"94px","height"=>"94px"));
							?>
						</div>
						<h2><a href="<?php echo $this->Html->url("/profile/".$user['Userdetail']['user_id']."/".$this->Common->makeurl($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name'])); ?>"><?php echo h($user['Userdetail']['designation'].' '.$username); ?></a><br />
						<span><?php echo h($user['Userdetail']['heading']); ?></span>
						</h2>
						<div class="clear-fix"></div>
						<p><?php echo strip_tags(substr($user['Userdetail']['biography'],0,500),"<br>,<br/>");   echo (strlen($user['Userdetail']['biography'])>500)?$this->Html->link("...More",array("controller"=>"profile","action"=>$user['Userdetail']['user_id'],$this->Common->makeurl($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']))):""; ?> </p>
<!--====View course other course Sart====-->
				<div class="other-courses">
				<h3>Other Courses from <span><?php echo $username; ?></span></h3>
				<ul>
					<?php foreach($usercourses as $usercoursekey=>$usercourseval) { ?>
						<li>	
							<div class="image">
								<span class="img_1">
									<a href="<?php echo $this->Html->url("/c/".$usercourseval['Course']['id'].'/'.$this->Common->makeurl($usercourseval['Course']['title'])); ?>" title="<?php echo $usercourseval['Course']['title']; ?>">
										
										<?php 
										// use thumb path from helper
										$courseImgPathThumb1 = ((!empty($usercourseval['Course']['coverimage']) && file_exists(WWW_ROOT.$usercourseval['Course']['coverimage']))?$usercourseval['Course']['coverimage']: "/img/no-img.png");
										$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, MediumCourseImagePrefix);
										echo $this->Html->image($courseImgThumb1,array("alt"=>$usercourseval['Course']['title'],"height"=>"96","width"=>"96"));
										
										?>
									</a>
								</span>
							   </div>
							<div class="txt_1">	
									<span><?php echo $usercourseval['Course']['students']; ?></span> Students<br>
									<span class="pric"><?php echo empty($usercourseval['Course']['price'])?"Free":"$".$usercourseval['Course']['price']; ?></span>
									<span class="rating_star">
										<?php echo $this->element("ratingstars",array("rating"=>$usercourseval['Course']['avgrating'])); ?>
									</span>
								
							</div> 
							<div class="clear-fix"></div>
							<h2><a href="<?php echo $this->Html->url("/c/".$usercourseval['Course']['id'].'/'.$this->Common->makeurl($usercourseval['Course']['title'])); ?>" title="<?php echo $usercourseval['Course']['title']; ?>"><?php echo $usercourseval['Course']['title']; ?></a></h2>
							<p><?php echo $usercourseval['Course']['subtitle']; ?></p>
						</li>
					<?php } ?>
				</ul>
				<div class="btm-link">
					<h4><?php echo $username; ?> authored <?php echo $usercoursescount; ?> courses</h4> 
					<span class="right"><a href="<?php echo $this->Html->url("/viewallcourse/".$coursedetail['Course']['user_id']); ?>" title="View All" class="button">View All</a></span> 
				</div>
			</div>	
<!--====View course other course end====-->	
						
					</div>
				</div>

<!--====View course Instructors End====-->

<!--====View course Already user Sart====-->
				<div class="already-user">
					<h3><?php echo $userlearningcoursecount; ?> users are already taking this course</h3>
					<div class="inner">
						<?php if(!empty($userlearningcourse)) { ?>
							<?php foreach($userlearningcourse as $userlearningcoursekey=>$userlearningcourseval) { ?>
								<?php if($this->Session->read("Auth.User.id")) { ?>
									<a href="#inline_content" class="inline students" id="<?php echo base64_encode($userlearningcourseval['Userdetail']['user_id']); ?>" >
								<?php } else { ?>
									<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist" >
								<?php } ?>
									<?php 
									// use thumb path from helper
									$proImgPathThumb1 = ((!empty($userlearningcourseval['Userdetail']['image']) && file_exists(WWW_ROOT.$userlearningcourseval['Userdetail']['image']))?$userlearningcourseval['Userdetail']['image']: "/img/no-img.png");
									$proImgThumb1 = $this->Common->getImageName($proImgPathThumb1, ThumbImageProfilePrefix);
									echo $this->Html->image($proImgThumb1,array("alt"=>$userlearningcourseval['Userdetail']['first_name'].' '.$userlearningcourseval['Userdetail']['last_name']));
									?>
								</a>
							<?php } ?>
						<?php } else { ?>
							No User Found
						<?php } ?>
						
					</div>
					<span class="rating_star"><span class="right mrgn_star">
							<?php echo $this->element("ratingstars",array("rating"=>isset($coursereview[0]['CourseReview']['avgrating'])?$coursereview[0]['CourseReview']['avgrating']:0)); ?>
						</span>Average Rating:
						
					</span>
					<span class="reviews fltlft"><a href="<?php echo $this->Html->url("/viewratings/".$coursedetail['Course']['id']); ?>" title="<?php echo $coursereviewcount; ?> Reviews"><?php echo $coursereviewcount; ?> Reviews</a></span>
				</div>
<!--====View course Already user End====-->
<div style="clear:both;">&nbsp;</div>
<!--====View Requirements Sart====-->
<?php /*
	<?php if(!empty($coursedetail['CourseRequirement'])) { ?>
		<?php $requirements = unserialize($coursedetail['CourseRequirement'][0]['title']); ?>
		<div class="already-user requirement">
			<h3>Requirements</h3>
			<div>
				<ul>
					<?php foreach($requirements as $reqkey=>$reqval) { ?>
						<li><?php echo $reqval; ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
<!--====View Requirements End====-->
<!--====View course tabpanel Sart====-->
	<div class="tabs">
	<div class="domtab">
		<ul class="domtabs">
			<li><a href="#Goals"  class="bdr-rt">Content and Goals</a></li>
			<li><a href="#Attend">Who Should Attend?</a></li>
		</ul>
		<div>
			<a name="Goals" id="Goals"></a>
			<ul>
				<?php if(!empty($coursedetail['CourseGoal'])) { ?>
					<?php $goals = unserialize($coursedetail['CourseGoal'][0]['title']); ?>
					<?php foreach($goals as $keygoal=>$valgoal) { ?>
						<?php if(!empty($valgoal)) { ?>
							<li><?php echo $valgoal; ?></li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
		<div>
			<a name="Attend" id="Attend"></a>
			<ul>
				<?php if(!empty($coursedetail['CourseAudience'])) { ?>
					<?php $audience = unserialize($coursedetail['CourseAudience'][0]['title']); ?>
					<?php foreach($audience as $keyaudience=>$valaudience) { ?>
						<?php if(!empty($valaudience)) { ?>
							<li><?php echo $valaudience; ?></li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
	</div>
	</div>
<!--====View course tabpanel End====--> */ ?>
<!--====View course reviews Sart====-->
				<div class="reviews">
				<span class="right"><span class="right mrgn_star">
						<?php echo $this->element("ratingstars",array("rating"=>isset($coursereview[0]['CourseReview']['avgrating'])?$coursereview[0]['CourseReview']['avgrating']:0)); ?>
					</span>Average Rating: 
					
				</span>
								
				<h3>Reviews</h3>
				<ul>
					<?php if(!empty($coursereview)) {  ?>
						<?php foreach($coursereview as $coursereviewkey=>$coursereviewval) {?>
							<li>	
								<div class="image"><?php if(!empty($coursereviewval['Userdetail']['image']) && file_exists(WWW_ROOT.$coursereviewval['Userdetail']['image'])) { echo $this->Html->image($coursereviewval['Userdetail']['image'],array("alt"=>$coursereviewval['Userdetail']['first_name'].' '.$coursereviewval['Userdetail']['last_name'])); } else { ?><?php echo $this->Html->image("/img/review-no-img.png",array("alt"=>$coursereviewval['Userdetail']['first_name'].' '.$coursereviewval['Userdetail']['last_name'])); } ?></div>
								<div class="txt">By <a href="<?php echo $this->Html->url("/profile/".$coursereviewval['Userdetail']['user_id']."/".$this->Common->makeurl($coursereviewval['Userdetail']['first_name'].' '.$coursereviewval['Userdetail']['last_name'])); ?>"><?php echo $coursereviewval['Userdetail']['first_name'].' '.$coursereviewval['Userdetail']['last_name']; ?></a><br />
										<span class="rating_star">
											<?php echo $this->element("ratingstars",array("rating"=>isset($coursereviewval['CourseReview']['rating'])?$coursereview[0]['CourseReview']['rating']:0)); ?> 
										</span>
									
								</div> 
								<span class="reviewtextnew">
									<?php echo $this->Common->removehtml($coursereviewval['CourseReview']['review_text']); ?>
								</span>
							</li>
						<?php } ?>
					<?php } else { ?>
						<li>	
							<div class="txt">No Reviews Found</div> 
						</li>
					<?php } ?>
				</ul>
				<div class="btm-link">
					<a class="pinterest" href="<?php echo $this->Html->url("/viewratings/".$coursedetail['Course']['id']); ?>" title="See all <?php echo $coursereviewcount; ?> user reviews"> <span class="prview-icon">See all <span class="txt"><?php echo $coursereviewcount; ?></span> user reviews</span></a>
				</div>
			</div>	
<!--====View course reviews end====-->	

			</div>
<!--====View course Right Panel End====-->
