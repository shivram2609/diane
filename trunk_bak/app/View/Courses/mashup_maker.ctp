<?php echo $this->Html->css(array("mashup.editor")); ?>
<?php echo $this->Html->script(array("mashup/mashup", "mashup/mashup.editor")); ?>

    <div class="video_outer">
        <div id="video_player_box">
            <video id="my_video" width="350" height="480" poster="<?php //echo $this->base . VIDEO_POSTER_URL . "7488lecturevideo.jpg"; ?>">
                <source src="<?php echo $videoUrl.".mp4" ?>" type='video/mp4' />
                <source src="<?php echo $videoUrl.".webm" ?>" type='video/webm' />
            </video>
			 <div id="prviewSlctdImgDiv" class="prviewSlctdImgDiv prviewSlctdImgDiv_3">

			</div>
			
            <div class="next_and_preview_section">
            <div id="slctdImgWrapr">	
                <a href="javascript:void(0);" id="prevUpr">Prev</a>	
                <div class="renderedImgPrntDiv" id="renderedImgPnlDiv1">
                    <ul id="renderedImgUl-1"></ul>
                </div>
                <a href="javascript:void(0);" id="nextUpr">Next</a>		
            </div>
			 </div>
            <div id="video_controls_bar">
                <input type="button" id="playpausebtn">

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

                <span class="fullscreenbtn"><input type="button" id="fullscreenbtn"></span>
                <span class="dimlightbtn"><input type="button" id="dimlight"></span>
            </div>
            <div id="video_ready_fade" class="video_ready_fade"></div>	
            <div id="video_center_play" class="video_center_play"></div>	

        </div>
        <div class="next_and_preview_section_2">	
        <div id="renderedImgWrapr" style="margin:0 auto; position: relative;">	
            <a href="javascript:void(0);" id="prevLwr">Prev</a>	
            <div class="renderedImgPrntDiv" id="renderedImgPnlDiv2">
                <ul id="renderedImgUl-2"></ul>
            </div>
            <a href="javascript:void(0);" id="nextLwr">Next</a>
        </div>
		
        <div id="renderedImgsLoding"></div>	
    </div>
	<div class="button_main_video">
    <input type="button" value="Preview" id="preview" class="mashup_action_button" />
    <input type="button" value="Submit" id="submit" class="mashup_action_button" /> 
	</div>
    
	
	
</div>
<div id="shadow" style="height: 779px; display: block;"></div>	
