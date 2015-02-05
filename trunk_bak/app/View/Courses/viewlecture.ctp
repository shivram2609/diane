<?php echo $this->Html->script("assets/jwplayer"); ?>
<script type="text/javascript">
	var primaryCookie = 'html5';
	var skinURL = "<?php echo SITE_LINK; ?>js/assets/skins/six/six.xml";
	
</script>
<?php if(!empty($mashdata['CourseMashup']['video'])) { ?>
<?php echo $this->Html->css(array("mashup.player")); ?>
<?php echo $this->Html->script(array("mashup/mashup", "mashup/mashup.player")); ?>
	<script>
		$(document).ready(function() {
			mashupXmlUrl = "<?php echo $mashdata['CourseMashup']['xml']; ?>";
			//Default Action
			$(".tab-content").hide(); //Hide all content
			$("ul.tabs-1 li:first").addClass("active").show(); //Activate first tab
			$(".tab-content:first").show(); //Show first tab content
			
			//On Click Event
			$("ul.tabs-1 li").click(function() {
				$("ul.tabs-1 li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab-content").hide(); //Hide all tab content
				var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active content
				return false;
			});

		});
	</script>
<?php } ?>
<div class="lecture-bg">
			<div class="lectr-rt" style="display:block;">
				<div class="questions">
					<h1><?php // pr($coursequestions); echo $coursequestions[0]['CourseUserQuestion']['course']; ?></h1>
					<?php foreach($courses as $key=>$val) { ?>
						<ul>	
							<li>
								<?php echo h($val['CourseSection']['heading']); ?>
								<ul>
									<?php if (!empty($val['CourseLecture'])) {  ?>
										<?php foreach($val['CourseLecture'] as $leckey=>$lecval) { ?>
											<li><a href="<?php echo $this->Html->url("/v/".$lecval['id']."/".$this->Common->makeurl($lecval['heading'])); ?>" title="<?php echo $lecval['heading']; ?>"><?php echo $lecval['heading']; ?></a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
						</ul>
					<?php } ?>
				</div>
			</div>
			<div class="lectr-lt">
			<span class="rt-blue-arrow" id="expandwindow"></span>
				<div class="innr">
					<p><a href="<?php echo $this->Html->url("/c/".$sections['CourseLecture']['course_id']."/".$this->Common->makeurl($sections['Course']['title'])); ?>" class="go-back">Back to Course</a><br>
			<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $sections['Course']['user_id']) { ?>
			<a href="<?php echo $this->Html->url("/course-manage/syllabus/".$sections['CourseLecture']['course_id']); ?>" class="edit-course">Edit Course</a>
			<?php } ?>
			</p>
			<span class="sect">Module <?php echo $sections['CourseSection']['section_index']; ?></span>
			<span class="lect">Lesson</span>
			<span class="nbr"><?php echo $sections['CourseLecture']['lecture_index']; ?></span>
					<p class="lecture-heading"><?php echo $sections['CourseLecture']['heading']; ?></p>
					<div class="video-1">
						<?php if($sections['CourseLecture']['content_type'] == 'P' || $sections['CourseLecture']['content_type'] == 'D') { ?>
							<iframe src="http://docs.google.com/gview?url=<?php echo SITE_LINK.$sections['CourseLecture']['content_source']; ?>&embedded=true" style="width:100%; height:530px;" frameborder="0" id="viewer_frame"></iframe>
							<?php } elseif($sections['CourseLecture']['content_type'] == 'V' || $sections['CourseLecture']['content_type'] == 'A' ) { 
								if($sections['CourseLecture']['content_external_link'] != 'None') {
									echo $sections['CourseLecture']['content_external_link'];
									
									if($sections['CourseLecture']['content_external_link'] == "Youtube") { ?>
										<iframe width="100%" height="520px" src="http://www.youtube.com/embed/<?php echo $sections['CourseLecture']['content_source']; ?>" frameborder="2" allowfullscreen></iframe>
									<?php } else { ?>
										<iframe src="http://player.vimeo.com/video/<?php echo $sections['CourseLecture']['content_source']; ?>" width="100%" height="520px" frameborder="2" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
									<?php } 
								} else {
								?>
									<div id="minimum" style="margin:auto;">
									</div>
									<?php if($sections['CourseLecture']['content_type'] == 'V') { 
										?>
										<?php echo $this->Html->css(array("video.player.new"));  ?>
										<?php echo $this->Html->script(array("video.player"));  ?>
										<div id="video_player_box1">
											<video id="my_video1" width="75%" height="75%" poster="<?php echo SITE_LINK.$sections['CourseLecture']['content_source'].".jpg"; ?>">
												<source src="<?php echo SITE_LINK.$sections['CourseLecture']['content_source']; ?>" type='video/mp4' />
												<source src="<?php echo SITE_LINK.$sections['CourseLecture']['content_source'].".webm"; ?>" type='video/webm' />
											</video>
											<div id="video_controls_bar1">
												<input type="button" id="playpausebtn1" />

												<div class="seekslider-outer1">
													<div id="seekslider1">
														<div id="ui-slider-range2-1"></div>
													</div>
												</div>
												<div class="time_main1">
													<span id="curtimetext1">00:00</span> / <span id="durtimetext1">00:00</span></div>
												<div class="volume-box1">
													<a id="mutebtn1" title="Mute/Unmute"></a>
													
													<div class="volume-slider1" id="volumeslider1"></div>
												</div>
												
												<span class="fullscreenbtn1"><input type="button" id="fullscreenbtn1" /></span>
												<span class="dimlightbtn1"><input type="button" id="dimlight1"></span>
											</div>
											<div id="video_ready_fade1" class="video_ready_fade1"></div>	
											<div id="video_center_play1" class="video_center_play1"></div>	
										</div>
										<div id="shadow1" style="height: 779px; display: block;"></div>	
									
									<?php /*<script type="text/javascript">
										jwplayer("minimum").setup({
											file: '<?php echo SITE_LINK.$sections['CourseLecture']['content_source']; ?>',
											image: '<?php echo SITE_LINK.$sections['CourseLecture']['content_source'].".jpg"; ?>',
											primary: primaryCookie,
											skin: skinURL,
											width: 893,
											height:520,
											stretching: "fill"
										});
									</script> */ ?>
									<?php } else { ?>
									<?php echo $this->Html->css(array("audio.player"));  ?>
									<?php echo $this->Html->script(array("audio.player"));  ?>
									<div class="container_audio">
										<div id="audio_player_box">
											<audio id="my_audio" width="450" height="350" poster="<?php echo SITE_LINK."/app/webroot/img/audio-animated1.gif"; ?>">
												<source src="<?php echo SITE_LINK.$sections['CourseLecture']['content_source']; ?>" type='audio/mpeg; codecs="mp3"' />
												<source src="<?php echo SITE_LINK.$sections['CourseLecture']['content_source'].".ogg"; ?>" type='audio/ogg; codecs="vorbis"' />
												Your browser does not support the audio element, Please update your browser.
											</audio>
											<div id="audio_controls_bar">
												<button id="playpausebtn"></button>

												<div class="seekslider-outer">
													<div id="seekslider">
														<div id="ui-slider-range2"></div>
													</div>
												</div>
												<div class="time_main">
													<span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span></div>
												<div class="volume-box">
													<a id="mutebtn" title="Mute/Unmute"></a>
													<div class="volume-slider" id="volumeslider"></div>
												</div>
											</div>
											<div id="audio_ready_fade" class="audio_ready_fade"></div>	
										</div>

									</div>
									<?php /*<script type="text/javascript">
										jwplayer("minimum").setup({
											file: '<?php echo SITE_LINK.$sections['CourseLecture']['content_source']; ?>',
											image: '<?php echo SITE_LINK."/app/webroot/img/audio-animated1.gif"; ?>',
											primary: primaryCookie,
											skin: skinURL,
											width: 893,
											height:520,
											stretching: "fill"
										});
									</script>*/	?>
									<?php } ?>
								<?php } ?>
							<?php } elseif($sections['CourseLecture']['content_type'] == 'T' || empty($sections['CourseLecture']['content_type'])) { ?>
								<?php if(!empty($sections['CourseLecture']['content'])) { ?>
									<div class="showcontent">
										
										<textarea id="coursecontent" class="addtext" readonly><?=$sections['CourseLecture']['content'] ?></textarea>
										<?php //echo $this->Common->removetags(nl2br($sections['CourseLecture']['content'])); ?></div>
										<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
										<?php  echo $this->Fck->viewlecturecontent("addtext"); ?>
								<?php } else { ?>
									<div class="showcontent"><textarea id="coursecontent" class="addtext" rows="32" cols="142" readonly>No Content Found</textarea></div>
									<?php  echo $this->Fck->viewlecturecontent("addtext"); ?>
									<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
								<?php } ?>
							<?php } elseif($sections['CourseLecture']['content_type'] == 'M' ) {  ?>


								<div class="video_outer">
									<div id="video_player_box">
										<div id="prviewSlctdImgDiv" class="prviewSlctdImgDiv"> </div>
										<video id="my_video" width="460" height="480" poster="<?php //echo $this->base . VIDEO_POSTER_URL . "7488lecturevideo.jpg"; ?>">
											<source src="<?php echo MashupVideoUrl.$mashdata['CourseMashup']['video'].".mp4" ?>" type='video/mp4' />
											<source src="<?php echo MashupVideoUrl.$mashdata['CourseMashup']['video'].".webm" ?>" type='video/webm' />
										</video>

										<div id="slctdImgWrapr" class="slctdImgWrapr">	
											<a href="javascript:void(0);" id="prevUpr">Prev</a>	
											<div class="renderedImgPrntDiv" id="renderedImgPnlDiv1">
												<ul id="renderedImgUl-1"></ul>
											</div>
											<a href="javascript:void(0);" id="nextUpr">Next</a>		
										</div>
										<div id="slctdImgsLoding"></div>	
										<div id="video_controls_bar">
											<button id="playpausebtn"></button>

											<div class="seekslider-outer">
												<div id="seekslider">
													<!--<div id="ui-slider-range2"></div>-->
												</div>
											</div>
											<div class="time_main">
												<span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span></div>
											<div class="volume-box">
												<a id="mutebtn" title="Mute/Unmute"></a>

												<div class="volume-slider" id="volumeslider"></div>
											</div>

											<span class="fullscreenbtn"><button id="fullscreenbtn"></button></span>
											<span class="dimlightbtn"><button id="dimlight"></button></span>
										</div>
										<div id="video_ready_fade" class="video_ready_fade"></div>	
										<div id="video_center_play" class="video_center_play"></div>	
									</div>

								</div>
								<div id="shadow" style="height: 779px; display: block;"></div>	



						<?php } ?>
					</div>
					<!--span class="auto-ply"><a href="javascript:void(0);" title="Auto Play ON "> Auto Play <span>ON</span></a></span-->
						<div class="lect-share">	
							<div class="lect-share-icon">
								<?php if(empty($sections['CourseLecture']['markcomplete'])) { ?>
									<a href="javascript:void(0);" class="marklecturecomplete" id="<?php echo $sections['CourseLecture']['course_id'].'_'.$sections['CourseLecture']['id']; ?>" title="Mark as Completed"><img src="<?php echo $this->webroot; ?>img/gray-bullet.png" alt="Lesson video" width="29" height="29"></a>
									<div class="drp-box2" style="width:100px;">
										Mark as Completed
									</div>
								<?php } else { ?>
									<a href="javascript:void(0);" class="marklecturecomplete" id="<?php echo $sections['CourseLecture']['course_id'].'_'.$sections['CourseLecture']['id']; ?>" title="Mark as Incompleted"><img src="<?php echo $this->webroot; ?>img/rt-bullet.png" alt="lesson video" width="29" height="29"></a>
									<div class="drp-box2" style="width:100px;">
										Mark as Incompleted
									</div>
								<?php } ?>
							</div>
							<div class="lect-share-icon">
								<a href="javascript:void(0);" title="Share"><img src="<?php echo $this->webroot; ?>img/share-icon.png" alt="lecture video" width="29" height="29"></a>
							<div class="drp-box1">
									<a title="Facebook" class="fb st_facebook_large" displayText='Facebook' href="javascript:void(0);">Facebook</a>
									<a title="Twitter" class="tr st_twitter_large" displayText='Tweet' href="javascript:void(0);">Twitter</a>
									<span class='st_facebook_large st_fb_large' displayText='Facebook'></span>
									<span class='st_twitter_large st_tr_large' displayText='Tweet'></span>
							</div>
						</div>
					</div>	
				</div>
			</div>
				
		</div>
<!--====Lecture Bottom Section Start====-->			
			<div class="lecture-btm">
				<div class="ask-question">
				<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $sections['Course']['user_id']) { ?>
					<h2>Questions </h2>
				<?php } else { ?>
					<h2>Your Questions </h2>
				<?php } ?>
					<ul id="questcontnew">
						<?php foreach($coursequestions as $qstkey=>$qstval) {  ?>
							<li id="qstrow_<?php echo $qstval['CourseUserQuestion']['id']; ?>"><a href="<?php echo $this->Html->url("/question/".$qstval['CourseUserQuestion']['id']); ?>" class="openquestionpop"><?php echo (!empty($qstval['CourseUserQuestion']['heading'])?$qstval['CourseUserQuestion']['heading']:$qstval['CourseUserQuestion']['question']); ?></a> 	<span class="right"><?php echo date("M d",strtotime($qstval['CourseUserQuestion']['created'])); ?></span>
							<?php if(isset($asked)) { ?>
								<span class="right"><a href="javascript:void(0);" id="remqst_<?php echo $qstval['CourseUserQuestion']['id']; ?>" class="remqst">Remove</a></span>
							<?php } ?>
							</li>
						<?php } ?>
					</ul>
					<p>&nbsp;</p>
				<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") != $sections['Course']['user_id']) { ?>
					<h2 id="show_askquestion_id">Ask a Question</h2>
					<?php echo $this->Form->create("Course",array("class"=>"hide")); ?>
					<?php echo $this->Form->hidden("course_id",array("value"=>$sections['CourseLecture']['course_id'])); ?>
					<?php echo $this->Form->hidden("course_lecture_id",array("value"=>$sections['CourseLecture']['id'])); ?>
					<?php echo $this->Form->hidden("course_section_id",array("value"=>$sections['CourseLecture']['course_section_id'])); ?>
						
						<label>Title:</label>
						<?php echo $this->Form->input("heading",array("label"=>false,"div"=>false,"maxlength"=>100)); ?>
						<div class="clear-fix"></div>
						<label>Question Text:</label>
						<?php echo $this->Form->input("question",array("type"=>"textarea","class"=>"txtarea","label"=>false,"rows"=>"1","cols"=>"53","div"=>false)); ?>
						<div class="clear-fix"></div>
						<?php echo $this->Form->submit("Ask Question",array("label"=>false,"div"=>false,"class"=>"all-btn left")); ?> 
						<a href="javascript:void(0);" title="Cancel" class="cancel-btn closewithcancle" >Cancel</a></p>
					<?php echo $this->Form->end(); ?>
				<?php } ?>
				</div>
				<div class="supp-material">
					<h2>Supplementary material</h2>
					<?php foreach($sections['CourseSuppliment'] as $key=>$val) { ?>
						<div class="rows removefile_<?php echo $val['id']; ?>">
							<?php if(!empty($val['content_source'])) { ?>
								<a href="javascript:void(0);" class="downloadfile" id="download_<?php echo $val['id']; ?>" title="<?php echo $val['content_title']; ?>"><span class="downlaod-icn downloadfile" id="downloads_<?php echo $val['id']; ?>"><?php echo h($val['content_title']); ?></span></a>
								<span class="downlaod-size"><?php echo $this->Common->formatbytes(WWW_ROOT.$val['content_source'],"MB"); ?> <a href="javascript:void(0);" class="removefile" id="remove_<?php echo $val['id']; ?>">Remove</a></span>
							<?php } else { ?>
								<span class="downlaod-icn"><a href="<?php echo $val['content_link'] ?>" target="_blank">External File</a> <a href="javascript:void(0);" class="removefile" id="remove_<?php echo $val['id']; ?>">Remove</a></span>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
<!--====Lecture Bottom Section End====-->				
			
		</div>
<?php echo $this->Html->script("jquery.colorbox"); ?>
<?php echo $this->Html->css("colorbox"); ?>
<?php echo $this->Colorbox->openexternalpopups ("openquestionpop","600px","1020px"); ?> 
