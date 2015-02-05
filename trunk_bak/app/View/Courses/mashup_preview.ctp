<?php echo $this->Html->css(array("mashup.player")); ?>
<?php echo $this->Html->script(array("mashup/mashup", "mashup/mashup.player")); ?>
<script type="text/javascript">
    mashupXmlUrl = "<?php echo $mashupXml; ?>";
</script>

<div class="container">
    <div class="video_outer">
        <div id="video_player_box">
            <div id="prviewSlctdImgDiv" class="prviewSlctdImgDiv"> </div>
            <video id="my_video" width="460" height="480" poster="<?php //echo $this->base . VIDEO_POSTER_URL . "7488lecturevideo.jpg"; ?>">
                <source src="<?php echo $mashupVideo.".mp4" ?>" type='video/mp4' />
                <source src="<?php echo $mashupVideo.".webm" ?>" type='video/webm' />
                <source src="<?php echo $mashupVideo.".ogv" ?>" type='video/ogg' />
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
                        <div id="ui-slider-range2"></div>
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

</div>
