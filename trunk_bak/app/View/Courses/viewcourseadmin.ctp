<div class="container">
		<div class="pub-pre-box">
			<span class="comp-img ">
				<?php  //pr($coursedetail); die;
				// use thumb path from helper
					$courseImgPathThumb1 = ((!empty($coursedetail['Course']['coverimage']) && (file_exists(WWW_ROOT.$coursedetail['Course']['coverimage'])))?$coursedetail['Course']['coverimage']: "/img/no-img.png");
					$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
					echo $this->Html->image($courseImgThumb1,array("alt"=>$coursedetail['Course']['title'],"width"=>"110","height"=>"60px"));
				?>
			</span>
			<div class="comp-txt">
				<h3><?php echo strip_tags($coursedetail['Course']['title'],"<p>,<strong>,<br>,<br/>"); ?></h3>
				By <a href="<?php echo $this->Html->url("/profile/".$user['Userdetail']['user_id']."/".$this->Common->makeurl($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name'])); ?>" target="_blank" title="<?php echo ucwords($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?>"><?php echo ucwords($user['Userdetail']['designation']); ?> <?php echo ucwords($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?></a>
			</div>
			<?php if(isset($instructor)) { ?>
				<span class="btn-pre acc_drpdwn1" ><a class="img button" href="<?php echo $this->Html->url("/course-manage/syllabus/".$coursedetail['Course']['id']); ?>">Manage This Course</a></span>
			<?php } ?>
				<div class="course-dboard-btns">
					<div class="course-dash-btns">
						<span class="info-icon"><a href="javascript:void(0);" title="Students"><img src="<?php echo $this->webroot; ?>img/user-icon-blk.png" width="26" height="18" alt="Info" /><?php echo $userlearningcoursecount; ?></a></span>
						<div class="share-icon"><a href="javascript:void(0);" title="Share This Course"><img src="<?php echo $this->webroot; ?>img/sharw-icon.png" width="18" height="18" alt="Info" /></a>
							<div class="drp-box">
								<span class='st_facebook_large' displayText='Facebook'></span>
								<span class='st_twitter_large' displayText='Tweet'></span>
								<span class='st_email_large' displayText='Email'></span>
							</div>
						</div>
					</div>
				</div>
		</div>
		<?php echo $this->Session->flash(); ?><br/><br/>

<!--======Right panel=====-->
		<div class="course-dbord-rt">
					<h2 class="heading"><span class="left">AVERAGE RATING :</span> <?php echo $this->element("ratingstars",array("rating"=>isset($coursereview[0]['CourseReview']['avgrating'])?$coursereview[0]['CourseReview']['avgrating']:0)); ?></h2>
				<br/>
			<div class="gry-box-1">
				
				<h2 class="heading">SYLLABUS</h2>
				<?php $lecture = 0; $completecount = 0; $nextlecid = $nextlectitle = '';
				 foreach($courses as $key=>$val) { ?>
					<div class="inner">
						<h5>
							<span class="section">Module</span>
							<span class="no"><?=($val['CourseSection']['section_index']); ?></span>
							<span class="title"><?php echo __($val['CourseSection']['heading']); ?></span>
						</h5>
						<ul>
							<?php if(!empty($val['CourseQuiz'])) { 
								$quizlecture = array();
								$i = 0;
								foreach($val['CourseQuiz'] as $quizkey=>$quizval) { 
									if(empty($quizval['course_lecture_id'])) {  ?>
										<li>
											<div class="lctre">Quiz <?php echo ++$i; ?>:</div>
											<div class="circle "></div>
											<h6>
												<a href="<?php echo $this->Html->url("/q/".$quizval['id']."/".$this->Common->makeurl($quizval['heading'])); ?>"> <?=$quizval['heading']; ?> </a>
											</h6>
											<span class="video"></span>
											<time></time>
											<a href="<?php echo $this->Html->url("/q/".$quizval['id']."/".$this->Common->makeurl($quizval['heading'])."/".$typeofview); ?>" class="start" title="Start Quiz" >Start Quiz</a>
										</li>
									<?php } else {
										$quizlecture[$quizval['course_lecture_id']][] = $quizval;
									}
								}
							} 
							if (!empty($val['CourseLecture'])) {  
								foreach($val['CourseLecture'] as $leckey=>$lecval) { $lecture++; ?>
									<li>
										<div class="lctre">Lesson <?php echo $lecval['lecture_index']; ?>:</div>
										<div class="circle "></div>
										<h6>
											<a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>">
												<?=($lecval['heading']); ?>
											</a>
										</h6>
										<span class="video"></span>
										<time></time>
										<?php if(in_array($lecval['id'],$completedlist)) { $completecount++; ?>
											<a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>" class="start" title="Completed Lesson" >Completed Lesson</a>
										<?php } else { 
												if (empty($nextlecid)) {
													$nextlecid = $lecval['id'];
													$nextlectitle = $lecval['heading'];
												}
											?>
											<a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>" class="start" title="Start Lesson" >Start Lesson</a>
										<?php } ?>
									</li>
									<?php if (isset($quizlecture[$lecval['id']])) { 
										foreach($quizlecture[$lecval['id']] as $quizleckey=>$quizlecval) { ?>
											<li>
												<div class="lctre">Quiz <?php echo ++$i; ?>:</div>
												<div class="circle "></div>
												<h6>
													<a href="<?php echo $this->Html->url("/q/".$quizlecval['id']."/".$this->Common->makeurl($quizlecval['heading'])); ?>"> <?=$quizlecval['heading']; ?> </a>
												</h6>
												<span class="video"></span>
												<time></time>
												<a href="<?php echo $this->Html->url("/q/".$quizlecval['id']."/".$this->Common->makeurl($quizlecval['heading'])."/".$typeofview); ?>" class="start" title="Start Quiz" >Start Quiz</a>
											</li>
										<?php }
									} ?>
								<?php }
							} ?>
							
						</ul>
					</div>
				<?php } ?>
			</div>
			<div class="gry-box">
				<?php if(!empty($lecture) && $completecount == $lecture) { ?>
					<a href="<?php echo $this->Html->url("/courses/create_pdf/".$coursedetail['Course']['id']."/".$this->Session->read("Auth.User.id")); ?>">
						Download Certificate of Completion
					</a>
				<?php } ?>
				<p>You have completed <?=$completecount; ?> of <?=$lecture; ?> Lessons in this course</p>
				<?php $progress = number_format((($completecount/$lecture)*99.8),"2",".",""); ?>
				<span class="progres-bar"><span class="upper" style=" width:<?php echo $progress; ?>%"></span></span><br />
				<?php if(!empty($nextlecid)) { ?>
					<span><a href="<?php echo $this->Html->url("/v/".$nextlecid."/".$this->Common->makeurl($nextlectitle)); ?>" class="button-1" title="Start with Lesson: Introduction and Installation">Start with Lesson: <?=$nextlectitle ?></a></span>
				<?php } ?>
			
			</div>
		</div>
<!--======Right panel End=====-->	
<!--======Left panel=====-->
		<div class="course-dbord-lt">
			
			<!--<div class="gry-box">RATE THIS COURSE
				<span class="rating-this"></span>
			</div>
			<div class="gry-box-1">
				<span class="certificate">To unlock your certificate, you need to<br /> complete 68 items!</span>
			</div>
			-->
			<?php if(!isset($instructor)) { ?>
			
				<div class="gry-box-1">
					<?php if(!isset($coursereviews)) { ?>
						<h2 class="heading">RATE THIS COURSE</h2>
						<?php echo $this->Form->create("CourseReview"); ?>
						<ul>
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
						<?php echo $this->Form->submit("Rate", array("class"=>'all-btn')); ?>
					<?php } else { ?>
						<h2 class="heading">YOUR RATING TO THIS COURSE</h2>
						<?php echo $this->Form->create("CourseReview"); ?>
						<ul>
						<li>
							<?php for($count_review = 1; $count_review <= 5; $count_review++) { ?>
								<?php 
									if ($count_review <= $coursereviews['CourseReview']['rating']) {
										echo $this->Html->image("/img/rating-star.png",array("class"=>"ratestar","id"=>"rate_".$count_review)); 
									} else {
										echo $this->Html->image("/img/rating-star-1.png",array("class"=>"ratestar","id"=>"rate_".$count_review)); 
									}
								?>
							<?php } ?>
							<?php echo $this->Form->hidden("rating",array("value"=>$coursereviews['CourseReview']['rating'])); ?>
						</li>
						<li><?php echo $this->Form->input("review_text",array("type"=>"textarea","value"=>$coursereviews['CourseReview']['review_text'],"div"=>false,"label"=>false,"placeholder"=>"Write Review")); ?></li>
						</ul>
						<?php echo $this->Form->submit("Rate", array("class"=>'all-btn')); ?>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="gry-box-1">
				<?php if(isset($questionforme) && $questionforme == 1) { ?>
					<h2 class="heading">COURSE QUESTIONS</h2>
				<?php } else { ?>
					<h2 class="heading">YOUR QUESTIONS</h2>
				<?php } ?>
				<ul>
					<?php
					if(!empty($data)) {
						foreach($data as $key=>$val) {
							?>
							<li>
								<a href="<?php echo $this->Html->url("/question/".$val['CourseUserQuestion']['id']); ?>" class="openquestionpop start">
									<?php echo h($val['CourseUserQuestion']['question']); ?>
								</a>
								<span style="float:right;"><?php echo $this->Common->otherDiffDate($val['CourseUserQuestion']['created']); ?></span>
							</li>
							<?php
						}
					} else {
					?>
					<li>No Record Found</li>
					<?php } ?>
				</ul>
			</div>
			
			
		</div>
<!--======Left panel End=====-->		
			
</div>
<?php echo $this->Html->script("jquery.colorbox"); ?>
<?php echo $this->Html->css("colorbox"); ?>
<?php echo $this->Colorbox->openexternalpopups ("openquestionpop","600px","1000px"); ?>
