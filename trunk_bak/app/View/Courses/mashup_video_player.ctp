<?php echo $this->Html->css(array("video.player"));  ?>
<?php echo $this->Html->script(array("video.player"));  ?>
	<div id="video_player_box1">
		<video id="my_video1" width="450" height="350" poster="<?php //echo $this->base.VIDEO_POSTER_URL."7488lecturevideo.jpg"; ?>">
			<source src="<?php echo $mashupVideo.".mp4" ?>" type='video/mp4' />
			<source src="<?php echo $mashupVideo.".webm" ?>" type='video/webm' />
			<source src="<?php echo $mashupVideo.".ogv" ?>" type='video/ogg' />
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
