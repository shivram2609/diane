<?php echo $this->Html->script("assets/jwplayer"); ?>
<script type="text/javascript">
	var primaryCookie = 'html5';
	var skinURL = "<?php echo SITE_LINK; ?>js/assets/skins/six/six.xml";
</script>
	<!--====Top header banner====-->

<?php //pr($coursedetail); ?>
<div id="view-course-hdr">
	<?php pr($this->Session->flash()); ?>
	<div class="inner">
		
		<?php if($coursedetail['Course']['visibility'] == 'Private' && $coursedetail['Course']['privacy_type'] == 2 && !$this->Session->read("CoursePassword.".$this->Session->read("Auth.User.id").".".$coursedetail['Course']['id'])) { 
			echo $this->Session->flash();
		?>
		<h2>This course is password protected and you need to enter password first to view this course</h2>
		<?php
		//pr($_SESSION);
			echo $this->Form->create("Course"); 
			echo $this->Form->input("password",array("maxlength"=>20));
			echo $this->Form->submit("Submit");
			echo $this->Form->end();
		} else { ?>
			<span class="video">
			<?php if((strpos(strtolower($coursedetail['Course']['promovideo']), "vimeo.com"))) { 
				$data = $this->Common->video_info($coursedetail['Course']['promovideo']);
				//pr($data);
				?>
				<div class="video-frame1">
				<iframe src="http://player.vimeo.com/video/<?php echo $data['video_id']; ?>" width="511px" height="333px" frameborder="2" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
			<?php } elseif((strpos(strtolower($coursedetail['Course']['promovideo']), "youtube.com"))) { 
				$data = $this->Common->video_info($coursedetail['Course']['promovideo']);
				//pr($data);
				?>
				<div class="video-frame1">
				<iframe width="511px" height="333px" src="http://www.youtube.com/embed/<?php echo $data['video_id']; ?>" frameborder="2" allowfullscreen></iframe>
				</div>
			<?php } else { ?>
				<?php if(!empty($coursedetail['Course']['promovideo'])) { ?>
					<span id="minimum">
					</span>
					<script type="text/javascript">
						jwplayer("minimum").setup({
							file: '<?php echo SITE_LINK.$coursedetail['Course']['promovideo']; ?>',
							image:'<?php echo SITE_LINK.$coursedetail['Course']['promovideo'].".jpg"; ?>',
							primary: primaryCookie,
							skin: skinURL,
							width: 511,
							height:333
						});
					</script>
				<?php } else { 
						$CourseImgPathThumb1 = ((!empty($coursedetail['Course']['coverimage']) && file_exists(WWW_ROOT.$coursedetail['Course']['coverimage']))?$coursedetail['Course']['coverimage']: "/img/no-img.png");
							$ProfileImgThumb1 = $this->Common->getImageName($CourseImgPathThumb1, LargeCourseImagePrefix);
							echo $this->Html->image($ProfileImgThumb1,array("alt"=>$coursedetail['Course']['title'],"width"=>"511px","height"=>"333px"));
				 } ?>
			<?php } ?>
			</span>
			<div class="text">
			<h2><?php echo strip_tags($coursedetail['Course']['title'],"<p>,<strong>,<br>,<br/>"); ?></h2>
			<span class="alnleft"><?php echo strip_tags(ucfirst($coursedetail['Course']['subtitle']),"<p>,<strong>,<br>,<br/>"); ?></span><br />
			<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $coursedetail['Course']['user_id']) { ?>
				<a href="<?php echo $this->Html->url("/course-manage/guidelines/".$coursedetail['Course']['id']); ?>" title="View Course Settings" class="btn-lrg">View Course Settings</a><br />
			<?php } else { ?>
				<?php if(!$this->Session->read("Auth.User.id")) { ?>
					<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="btn-lrg wishlist ">Take This Course <span class="price"><?php echo empty($coursedetail['Course']['price'])?"Free":"$".$coursedetail['Course']['price']; ?></span></a><br />
				<?php } elseif(isset($usercourse)) { ?> 
					<a href="javascript:void(0);" title="Your Course" class="btn-lrg">Already Taken Course</a><br />
				<?php } else { if($coursedetail['Course']['pricetype']== 'Paid') { ?>
					<a href="<?php echo $this->Html->url("/takecourse/".$coursedetail['Course']['id']); ?>" title="Take This Course" class="btn-lrg paidcourse">Take This Course <span class="price">$<?php echo $coursedetail['Course']['price']; ?></span></a><br />
				<?php } else { ?>
					<a href="<?php echo $this->Html->url("/takecourse/".$coursedetail['Course']['id']); ?>" title="Take This Course" class="btn-lrg">Take This Course <span class="price">Free</span></a><br />
				<?php } } ?>
				<p class="icon-list"> 
					<!--a href="javascript:void(0);" title="Redeem a Coupon"><span class="coupon"></span>Redeem a Coupon</a> 
					<a href="javascript:void(0);" title="Free Preview"><span class="free-pre"></span>Free Preview</a-->
					<?php /* if($this->Session->read("Auth.User.id")) { ?>
					<a href="javascript:void(0);" title="Wishlist" class="addwishlist" id="addwish_<?php echo $coursedetail['Course']['id']; ?>"><span class="wand"></span><?php echo empty($coursedetail['Course']['wishlist'])?'Wishlist':'Wishlisted'; ?></a> 
					<?php } else { ?>
					<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist"><span class="wand"></span>Wishlist</a> 
					<?php } */ ?>
					<?php if(!empty($coursedetail['Course']['learningcount'])) { ?>
						<?php if($this->Session->read("Auth.User.id")) { ?>
						<a href="javascript:void(0);" title="<?php echo empty($coursedetail['Course']['learning'])?"Mark as Completed":"Completed"; ?>" class="markcomplete" id="completed_<?php echo $coursedetail['Course']['id']; ?>"><?php echo empty($coursedetail['Course']['learning'])?"Mark as Completed":"Completed"; ?></a> 
						<?php } else { ?>
						<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" class="wishlist">Mark as Completed</a> 
						<?php } ?>
					<?php } ?>
					<!--a href="javascript:void(0);" title="Gift"><span class="gift"></span>Gift</a--> 
				</p>
			<?php } ?>
			</div>
			</div>
			</div>
			<!--====Top header banner End====-->
			<div class="container">
			<?php echo $this->element('view-course-left');?>
			<?php echo $this->element('view-course-right');?>
			</div>
			<div style='display:none'>
			<div id='inline_content' style="background-color:#fff;">
				You need to take this course before viewing its lesson.<br/>
				<a href="<?php echo $this->Html->url("/takecourse/".$coursedetail['Course']['id']); ?>" title="Take This Course" class="btn-lrg">Take This Course <span class="price"><?php echo empty($coursedetail['Course']['price'])?"Free":"$".$coursedetail['Course']['price']; ?></span></a><br />
			</div>
			</div>
	<?php } ?>
