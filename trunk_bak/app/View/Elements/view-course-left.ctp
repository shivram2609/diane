<div id="view-course-lt">
	<span class="social-share">
		<span class='st_fblike_vcount' displayText='Facebook Like'></span>
		<span class='st_facebook_vcount' displayText='Facebook'></span>
		<span class='st_twitterfollow_vcount' displayText='Twitter Follow'></span>
		<span class='st_twitter_vcount' displayText='Tweet'></span>
		<span class='st_linkedin_vcount' displayText='LinkedIn'></span>
		<span class='st_pinterestfollow_vcount' displayText='Pinterest Follow'></span>
		<span class='st_pinterest_vcount' displayText='Pinterest'></span>
	</span>
	<h2>by <a href="<?php echo $this->Html->url("/profile/".$coursedetail['Course']['user_id']."/".$this->Common->makeurl($username)); ?>"><?php echo h($username);?></a></h2>
	<?php if(!empty($coursedetail['Course']['summary'])) { ?>
		<div class="course-content">
		<p><?php echo strip_tags($coursedetail['Course']['summary'],"<strong>,<br>,<br/>,<a>"); ?></p>
		</div>
	<?php } ?>
	<?php if(!empty($coursedetail['Category']['title'])) { ?>
		<br/>Category: <a href="<?php echo $this->Html->url("/view-courses/".$this->Common->makeurl($coursedetail['Category']['title'])."/".$coursedetail['Category']['id']); ?>" title="Clic here to view all courses related to <?php echo $coursedetail['Category']['title']; ?>"><?php echo h($coursedetail['Category']['title']); ?></a>
	<?php } ?>
	<?php if(!empty($coursedetail['Course']['lincence_logo'])) { ?>
		<br/><br/>License: <a href="<?php echo !empty($coursedetail['Course']['lincence_url'])?$coursedetail['Course']['lincence_url']:"javascript:void(0);" ?>" <?php echo !empty($coursedetail['Course']['lincence_url'])?"target='_blank'":"" ?> ><img src="<?php echo SITE_LINK.ltrim($coursedetail['Course']['lincence_logo'],"/"); ?>" /></a>
	<?php } ?>
	<?php if(!empty($coursedetail['Course']['source_title'])) { ?>
		<br/><br/><br/>Source: <a href="<?php echo !empty($coursedetail['Course']['source_url'])?"javascript:void(0);":"javascript:void(0);" ?>" <?php echo !empty($coursedetail['Course']['source_url'])?"":"" ?> ><?php echo h($coursedetail['Course']['source_title']); ?></a>
	<?php } ?>
	
	<div style="clear:both;"></div>
	<?php /* if($this->Session->read("Auth.User.id") && !empty($coursedetail['Course']['learningcount'])) { ?>
	<br/>
		<div class="user-view">
			<?php echo $this->Form->create("CourseReview"); ?>
			<ul>
			<li><a href="javascript:void(0);">Rate This Course</a></li>
			<li>
				<?php echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_1")); ?>
				<?php echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_2")); ?>
				<?php echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_3")); ?>
				<?php echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_4")); ?>
				<?php echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_5")); ?>
				<?php echo $this->Form->hidden("rating",array("value"=>"0")); ?>
			</li>
			<li><?php echo $this->Form->input("review_text",array("type"=>"textarea","div"=>false,"label"=>false,"placeholder"=>"Write Review")); ?></li>
			</ul>
			<?php echo $this->Form->submit("Rate"); ?>
		</div>
	<?php } */ ?>
	
<!--====View course Section Sart====-->
	<?php //pr($courses); //die; 
	$iconarr = array("V"=>"camera_icn.png","A"=>"radio_icn.png","P"=>"tv_icn.png","D"=>"book_icn.png","T"=>"pencil_icn.png",""=>"pencil_icn.png","M"=>"top_arrow_icn.png","quiz"=>"quiz_icon.png");
	$typearr = array("V"=>"Video","A"=>"Audio","P"=>"Presentation","D"=>"Document","T"=>"Text",""=>"Text","M"=>"Mashup","quiz"=>"Quiz");
	foreach($courses as $key=>$val) { ?>
		<h3>MODULE <?php echo __($val['CourseSection']['section_index']) ?>: <span><?php echo __($val['CourseSection']['heading']) ?></span></h3>
		<div class="pro-box">
			<ul>
		<?php if(!empty($val['CourseQuiz'])) { 
			$quizlecture = array();
			$i = 0;
			?>
				<?php foreach($val['CourseQuiz'] as $quizkey=>$quizval) { ?>
					<?php if(empty($quizval['course_lecture_id'])) { //die("here"); ?>
						<li>
							<?php if($this->Session->read("Auth.User.id")) {  ?>
								<?php if(!isset($usercourse)) { ?>
									<a href="#inline_content" class="inline">
								<?php } else { ?>
									<a href="<?php echo $this->Html->url("/q/".$quizval['id']."/".$this->Common->makeurl($quizval['heading'])); ?>">
								<?php } ?>
							<?php } else { ?>
								<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
							<?php } ?>
							<span class="img-icon">
								<img src="<?php echo $this->webroot; ?>img/<?php echo $iconarr['quiz']; ?>" />
							<br/>
							<?php echo $typearr["quiz"]; ?>
							</span></a>
							<span class="text">
								Quiz <?php echo ++$i; ?>:<br />
								<?php if($this->Session->read("Auth.User.id")) { ?>
									<?php if(!isset($usercourse) && $this->Session->read("Auth.User.id") != $coursedetail['Course']['user_id']) { ?>
										<a href="#inline_content" class="inline">
									<?php } else { ?>
										<a href="<?php echo $this->Html->url("/q/".$quizval['id']."/".$this->Common->makeurl($quizval['heading'])); ?>" title="<?php echo ($quizval['heading']); ?>" >
									<?php } ?>
								<?php } else { ?>
									<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
								<?php } ?>
								<?php echo $quizval['heading']; ?>
								
								</a>
							</span>
						</li>
					<?php } else {
						$quizlecture[$quizval['course_lecture_id']][] = $quizval;
				}
			}
		} ?>
		<?php if (!empty($val['CourseLecture'])) {  ?>
					<?php foreach($val['CourseLecture'] as $leckey=>$lecval) { ?>
							<li>
								<?php if($this->Session->read("Auth.User.id")) {  ?>
									<?php if(!isset($usercourse)) { ?>
										<a href="#inline_content" class="inline">
									<?php } else { ?>
										<a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>">
									<?php } ?>
								<?php } else { ?>
									<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
								<?php } ?>
								<span class="img-icon">
									<img src="<?php echo $this->webroot; ?>img/<?php echo $iconarr[$lecval['content_type']]; ?>" />
								<br/>
								<?php echo $typearr[$lecval['content_type']]; ?>
								</span></a>
								<span class="text">
									Lesson <?php echo $lecval['lecture_index']; ?>:<br />
									<?php if($this->Session->read("Auth.User.id")) { ?>
										<?php if(!isset($usercourse) && $this->Session->read("Auth.User.id") != $coursedetail['Course']['user_id']) { ?>
											<a href="#inline_content" class="inline">
										<?php } else { ?>
											<a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>" title="<?php echo ($lecval['heading']); ?>" >
										<?php } ?>
									<?php } else { ?>
										<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
									<?php } ?>
									<?php echo $lecval['heading']; ?>
									
									</a><br/>
									<?php echo in_array($lecval['id'],$completedlist)?'Completed':''; ?>
								</span>
							</li>
							<?php if (isset($quizlecture[$lecval['id']])) { ?>
								<?php foreach($quizlecture[$lecval['id']] as $quizleckey=>$quizlecval) { ?>
									<li>
										<?php if($this->Session->read("Auth.User.id")) {  ?>
											<?php if(!isset($usercourse)) { ?>
												<a href="#inline_content" class="inline">
											<?php } else { ?>
												<a href="<?php echo $this->Html->url("/q/".$quizlecval['id']."/".$this->Common->makeurl($quizlecval['heading'])); ?>">
											<?php } ?>
										<?php } else { ?>
											<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
										<?php } ?>
										<span class="img-icon">
											<img src="<?php echo $this->webroot; ?>img/<?php echo $iconarr['quiz']; ?>" />
										<br/>
										<?php echo $typearr["quiz"]; ?>
										</span></a>
										<span class="text">
											Quiz <?php echo ++$i; ?>:<br />
											<?php if($this->Session->read("Auth.User.id")) { ?>
												<?php if(!isset($usercourse) && $this->Session->read("Auth.User.id") != $coursedetail['Course']['user_id']) { ?>
													<a href="#inline_content" class="inline">
												<?php } else { ?>
													<a href="<?php echo $this->Html->url("/q/".$quizlecval['id']."/".$this->Common->makeurl($quizlecval['heading'])); ?>" title="<?php echo ($quizlecval['heading']); ?>" >
												<?php } ?>
											<?php } else { ?>
												<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">
											<?php } ?>
											<?php echo $quizlecval['heading']; ?>
											
											</a>
										</span>
									</li>
								<?php } ?>
							<?php } ?>
					<?php } ?>
		<?php } ?>
		</ul>
			</div>
	<?php } ?>
				
<!--====View course Section End====-->
<!--====View course user-view Sart====-->
				<h4><span class="right"><a href="<?php echo $this->Html->url("/viewrecents/".$coursedetail['Course']['id']); ?>" title="View All" class="button">View All</a></span> Users Who Viewed This Course Also Viewed</h4> 
				<div class="user-view">
					<?php //pr($usersview); ?>
					<?php if(!empty($coursedetail['Course']['coverimage']) && file_exists(WWW_ROOT.$coursedetail['Course']['coverimage'])) { ?>
					<span style="display:none;">
						<a href="<?php echo $this->Html->url("/c/".$coursedetail['Course']['id'].$this->Common->makeurl($coursedetail['Course']['title'])); ?>"><?php echo $this->Html->image($coursedetail['Course']['coverimage'],array("alt"=>$coursedetail['Course']['title'])); ?></a>
					</span>
					<?php } ?>
				<ul>
					<?php if(!empty($usersview)) { ?>
						<?php foreach($usersview as $userviewkey=>$userviewval) { ?>
							<li>	
								<div class="image">
									<a href="<?php echo $this->Html->url("/c/".$userviewval['Course']['id'].'/'.$this->Common->makeurl($userviewval['Course']['title'])); ?>" title="<?php echo $userviewval['Course']['title']; ?>">
										 
										<?php 
										// use thumb path from helper
										$cImgPathThumb1 = ((!empty($userviewval['Course']['coverimage']) && file_exists(WWW_ROOT.$userviewval['Course']['coverimage']))?$userviewval['Course']['coverimage']: "/img/no-img.png");
										$cImgThumb1 = $this->Common->getImageName($cImgPathThumb1, SmallCourseImagePrefix);
										echo $this->Html->image($cImgThumb1,array("alt"=>$userviewval['Course']['title'],"width"=>"96px","height"=>"96px"));
										?>
									</a>
								   <span><?php echo $userviewval['UserViewCourse']['students']; ?></span> Students
								 </div>
								<div class="txt"><h2><a href="<?php echo $this->Html->url("/c/".$userviewval['Course']['id'].'/'.$this->Common->makeurl($userviewval['Course']['title'])); ?>" title="<?php echo $userviewval['Course']['title']; ?>" title="<?php echo $userviewval['Course']['title']; ?>"><?php echo $userviewval['Course']['title']; ?></a></h2>
										<p><?php echo $userviewval['Course']['subtitle']; ?></p>
										<span class="pric"><?php echo empty($userviewval['Course']['price'])?"Free":"$".$userviewval['Course']['price']; ?></span>
										<span class="rating_star">
											<?php echo $this->element("ratingstars",array("rating"=>$userviewval['UserViewCourse']['review'])); ?>
										</span>
									
								</div>  
							</li>
						<?php } ?>
					<?php } else { ?>
						<li><div class="txt"><h2>No Records Found</h2></div></li>
					<?php } ?>
				</ul>
			</div>	
<!--====View course user-view end====-->	
			</div>
<!--====View course Left panel end====-->
