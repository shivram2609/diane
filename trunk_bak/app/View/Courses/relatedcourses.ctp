<div class="container">
	
		<div class="wish-list">
			<h1><?php echo $heading;?></h1>
			<div class="profile-btns">
			  <?php if(!isset($others)) { ?> 
					<?php /*<span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'w') echo  'selected'?>"><a href="<?php echo $this->Html->url("/mywishlist"); ?>" title="Wishlist">Wishlist (<?php echo $user['Userdetail']['wishlist'];?>)</a></span>  */ ?>
					<span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'l') echo  'selected'?>"><a href="<?php echo $this->Html->url("/myenrolled"); ?>" title="Enrolled Course">Enrolled (<?php echo $user['Userdetail']['learning'];?>)</a></span>  
					<span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'c') echo  'selected'?>"><a href="<?php echo $this->Html->url("/mycompleted"); ?>" title="Completed Course">Completed (<?php echo $user['Userdetail']['completed'];?>)</a></span> 
					<span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 't') echo  'selected'?>"><a href="<?php echo $this->Html->url("/mycourses"); ?>" title="Teaching Course">Teaching (<?php echo $user['Userdetail']['countcourse'];?>)</a></span>   
			  <?php } else { ?>
					<?php /* <span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'w') echo  'selected'?>"><a href="<?php echo $this->Html->url("/wishlist/w/".$user['Userdetail']['user_id']); ?>" title="Wishlist">Wishlist (<?php echo $user['Userdetail']['wishlist'];?>)</a></span>  */ ?>
					<span class="btns  <?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'l') echo  'selected'?>"><a href="<?php echo $this->Html->url("/enrolled/l/".$user['Userdetail']['user_id']); ?>" title="Enrolled Course">Enrolled (<?php echo $user['Userdetail']['learning'];?>)</a></span>  
			  <?php } ?>
			</div>
			<?php echo $this->Session->flash(); ?>
			<div class="listing">
			<?php if(isset($courses) && !empty($courses)){ ?>
			<ul>
				<?php
					foreach ($courses as $course) {
					
					if(isset($course['UserLearningCourse']['name'])){
						$name = $course['UserLearningCourse']['name'];
					} elseif(isset($course['UserWishlistCourse']['name'])){
						$name = $course['UserWishlistCourse']['name'];
					} elseif(isset($course['Course']['name']) && !empty($course['Course']['name'])){
						$name = $course['Course']['name'];
					} else{
						$name = '';
					}
				?>
				<?php
				/* code to show listing for wishlisted courses */
				 if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 'w') { ?>
				 <?php //pr($this->params); 
					$this->Paginator->options(array(
						'url' => array("controller"=>"mywishlist")
					));
				 ?>
					<li>
						<div class="img">
							<?php 
								// use thumb path from helper
								$courseImgPathThumb1 = ((!empty($course['Course']['coverimage']) && file_exists(WWW_ROOT.$course['Course']['coverimage']))?$course['Course']['coverimage']: "/img/no-img.png");
								$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
								echo $this->Html->image($courseImgThumb1,array("alt"=>$course['Course']['title'],"width"=>"112px","height"=>"112px"));
							?>
						</div>
						<div class="txt">
							<span class="right"><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="Wishlisted" class="view-course-btn right">Wishlisted</a><br/>
							<a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="View Course" class="mng-course-btn">View Course</a>
							</span>
							<h2><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo h($course['Course']['title']); ?></a></h2>
								<p><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo $this->Common->removetags(substr($course['Course']['summary'],0,500),array("<br>","<i>","b")); echo (strlen($course['Course']['summary']) > 500?" ...":""); ?>  </a></p>
								<span class="rating_star">
									<?php echo $this->element("ratingstars",array("rating"=>$course['UserWishlistCourse']['avgrating'])); ?>
								</span><a href="<?=$this->Html->url("/profile/".$course['Course']['user_id']."/".$this->Common->makeurl($name)); ?>"><?=ucwords($name); ?></a>
							<span class="users">
								<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $course['UserWishlistCourse']['totalstudents']; ?>
							</span>
							<span class="pric"><?php echo empty($course['Course']['price'])?"Free":"$".$course['Course']['price']; ?></span>
						</div> 
					</li>
				<?php /* code to show listing for wishlisted courses end here */
				  } elseif($this->params['controller'] == 'courses' && $this->params['pass'][0] == 't') { ?>
				  <?php //pr($this->params); 
					$this->Paginator->options(array(
						'url' => array("controller"=>"mycourses")
					));
				 ?>
					  <li>
							<div class="img">
								<?php 
									// use thumb path from helper
									$courseImgPathThumb1 = ((!empty($course['Course']['coverimage']) && file_exists(WWW_ROOT.$course['Course']['coverimage']))?$course['Course']['coverimage']: "/img/no-img.png");
									$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
									echo $this->Html->image($courseImgThumb1,array("alt"=>$course['Course']['title'],"width"=>"112px","height"=>"112px"));
								?>
							</div>
							<div class="txt">
								<span class="right">
									<a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="Wishlisted" class="view-course-btn right">View Course</a><br>
									<a href="<?php echo $this->Html->url('/course-manage/guidelines'."/".$course['Course']['id']); ?>" title="Manage Course" class="mng-course-btn">Manage Course</a>
								</span>
								<h2><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo h($course['Course']['title']); ?></a></h2>
									<p><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo $this->Common->removetags(substr($course['Course']['summary'],0,500),array("<br>","<i>","b")); echo (strlen($course['Course']['summary']) > 500?" ...":""); ?></a></p>
									<span class="rating_star">
										<?php echo $this->element("ratingstars",array("rating"=>$course['Course']['avgrating'])); ?>
									</span><a href="<?=$this->Html->url("/profile/".$course['Course']['user_id']."/".$this->Common->makeurl($name)); ?>"><?=ucwords($name); ?></a>
								<span class="users">
									<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $course['Course']['totalstudents']; ?>
								</span>
								<span class="pric"><?php echo empty($course['Course']['price'])?"Free":"$".$course['Course']['price']; ?></span>
							</div> 
						</li>
				<?php } else { ?>
				<?php //pr($this->params); 
					if($this->params['pass'][0] == 'l') {
						$this->Paginator->options(array(
							'url' => array("controller"=>"mylearnings")
						)); 
					} else {
						$this->Paginator->options(array(
							'url' => array("controller"=>"mycompleted")
						));
					}
				 ?>
					<li>
						<div class="img">
							<?php 
								// use thumb path from helper
								$courseImgPathThumb1 = ((!empty($course['Course']['coverimage']) && file_exists(WWW_ROOT.$course['Course']['coverimage']))?$course['Course']['coverimage']: "/img/no-img.png");
								$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
								echo $this->Html->image($courseImgThumb1,array("alt"=>$course['Course']['title'],"width"=>"112px","height"=>"112px"));
							?>
						</div>
						<div class="txt">
							<span class="right rightwidth">
								<a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="View Course" class="view-course-btn right">View Course</a><br>
								<a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" >
									<?php if(empty($course['UserLearningCourse']['completelecture'])) { ?>
										<span class="mng-course-btn">Start the Course</span>
									<?php } else {  ?>
										<?php $progresswidth = ($course['UserLearningCourse']['completelecture']/$course['UserLearningCourse']['totallecture'])*154; ?>
										<span class="mng-course-btn sml-txt"><span class="sml-progress-barbg"><span class="prgress-status" style=" width:<?php echo $progresswidth;  ?>px;"></span></span><br>Learn Again</span>
									<?php } ?>
								</a>
								<?php if(!empty($course['UserLearningCourse']['completelecture']) && !empty($course['UserLearningCourse']['totallecture']) && $course['UserLearningCourse']['completelecture'] == $course['UserLearningCourse']['totallecture'] ) { ?>
									<a href="<?php echo $this->Html->url("/courses/create_pdf/".$course['Course']['id']."/".$this->Session->read("Auth.User.id")); ?>"><span class="mng-course-btn sml-txt">Download Certificate of Completion</span></a>
								<?php } ?>
							</span>
							<h2><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo h($course['Course']['title']); ?></a></h2>
								<p><a href="<?php echo $this->Html->url('/c'."/".$course['Course']['id']."/".$this->Common->makeUrl($course['Course']['title'])); ?>" title="<?php echo h($course['Course']['title']); ?>"><?php echo $this->Common->removetags(substr($course['Course']['summary'],0,500),array("<br>","<i>","b")); echo (strlen($course['Course']['summary']) > 500?" ...":""); ?></a></p>
								<span class="rating_star">
									<?php echo $this->element("ratingstars",array("rating"=>$course['UserLearningCourse']['avgrating'])); ?>
								</span><a href="<?=$this->Html->url("/profile/".$course['Course']['user_id']."/".$this->Common->makeurl($name)); ?>"><?=ucwords($name); ?></a>
							<span class="users">
								<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $course['UserLearningCourse']['totalstudents']; ?>
							</span>
							<span class="pric"><?php echo empty($course['Course']['price'])?"Free":"$".$course['Course']['price']; ?></span>
						</div> 
					</li>
				<?php } ?>
			<?php } ?>
		<?php } else{
			?>
			
			<?php
				//echo "No Results Found!";
			?>
			
			<?php
		} 
		?>

		</ul>
		</div>
			<!--<?php if($this->params['controller'] == 'courses' && $this->params['pass'][0] == 't') { ?>
				<div class="more-discover"><a href="<?php echo $this->Html->url("/course-manage/create"); ?>"><img src="<?php echo $this->webroot; ?>img/add-more.png" width="88" height="90"> <br>Create Courses</a></div>
			<?php } elseif($this->params['controller'] == 'courses' && $this->params['pass'][0] != 'w') { ?>
				<div class="more-discover"><a href="<?php echo $this->Html->url("/view-courses"); ?>"><img src="<?php echo $this->webroot; ?>img/add-more.png" width="88" height="90"> <br>Discover More Courses</a></div>
			<?php } ?>-->
		</div>
		<?php if(count($courses) > 19 || isset($this->params['named']['page'])) { ?>
	 	<div class="pagination-box">
			<div class="paging">
				<span class="prev-pagination-lnk"><?php echo $this->Paginator->prev('< ' . __('Prev  '), array(), null, array('class' => 'prev disabled')); ?></span>
				<span class="pge-no"><?php echo $this->Paginator->numbers(array('separator' => '</span><span class="pge-no">'));?></span>
				<span class="next-pagination-lnk"><?php echo $this->Paginator->next(__('Next >'), array(), null, array('class' => 'next disabled'));?></span>
			</div>
		</div>
	<?php } ?>
</div>
