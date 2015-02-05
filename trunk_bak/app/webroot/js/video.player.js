var $vid1, $playBtn1, $seekSlider1, $curTimeTxt1, $durTimeTxt1, $muteBtn1, $volumeSlider1, $fulScrenBtn1, $vidPlayrBox1, $lightShadow1,
        $lightBtn1, $vidRdyFade1, $vidCntrPly1, seekSliding1, videoDuration1, fullScreenFlag1 = 0, lightIcon1, lastVolumeVal1, newVolumeVal1, percentVidLoaded1;

var IMAGES_PATH1 = BASE_URL + "/img/mashup/", VID_LOADED_WIDTH1 = 98, VID_LOADED_WIDTH_FS1 = 99.7, VID_WIDTH1 = '100%', VID_HEIGHT1 = '100%', SEEKBAR_OUTR_WIDTH1 = 60, SEEKBAR_OUTR_WIDTH_FS1 = 65; //constants

$(document).ready(function() {
    $vid1 = $("#my_video1");
    $playBtn1 = $("#playpausebtn1");
    $seekSlider1 = $("#seekslider1");
    $curTimeTxt1 = $("#curtimetext1");
    $durTimeTxt1 = $("#durtimetext1");
    $muteBtn1 = $("#mutebtn1");
    $volumeSlider1 = $("#volumeslider1");
    $fulScrenBtn1 = $("#fullscreenbtn1");
    $vidPlayrBox1 = $('#video_player_box1');
    $lightShadow1 = $('#shadow1');
    $lightBtn1 = $('#dimlight1');
    $vidRdyFade1 = $('#video_ready_fade1');
    $vidCntrPly1 = $('#video_center_play1');
    $lightShadow1.css("height", $(document).height()).hide();
    // play-pause function
    var vidPlay1 = function() {
		$vid1.unbind('click').click(vidPlay1);
		if ($vid1[0].paused) {
			$vidCntrPly1.hide();
			$vid1[0].play();
			$playBtn1.css('background', "url(" + IMAGES_PATH1 + "pause_button.png) no-repeat");
		} else {
			$vid1[0].pause();
			$playBtn1.css('background', "url(" + IMAGES_PATH1 + "play_button_2.png) no-repeat");
		}
    };

    $playBtn1.click(vidPlay1); //Bind click event on play button
    $vidCntrPly1.click(vidPlay1); //Bind click event on center play button

    //Light dim and on method
    $lightBtn1.click(function() {
        if ($lightShadow1.is(":visible")) {
            $lightShadow1.fadeOut('slow');
            lightIcon1 = "radial_light.png";
        } else {
            $lightShadow1.fadeIn('slow');
            lightIcon1 = "bulb_click.png";
        }
        $lightBtn1.css('background', "url(" + IMAGES_PATH1 + lightIcon1 + ") no-repeat scroll 0 -1px transparent");
    });

    //Seek bar update method
    var seekBarUpdate1 = function() {
        if (!seekSliding1) {
            $seekSlider1.slider("value", $vid1[0].currentTime); //update seek bar slider value
        }
        var curmins = Math.floor($vid1[0].currentTime / 60);
        var cursecs = Math.floor($vid1[0].currentTime - curmins * 60);
        var durmins = Math.floor($vid1[0].duration / 60);
        var dursecs = Math.floor($vid1[0].duration - durmins * 60);
        cursecs = cursecs < 10 ? "0" + cursecs : cursecs;
        dursecs = dursecs < 10 ? "0" + dursecs : dursecs;
        curmins = curmins < 10 ? "0" + curmins : curmins;
        durmins = durmins < 10 ? "0" + durmins : durmins;
        $curTimeTxt1.html(curmins + ":" + cursecs); //Update current time div
        $durTimeTxt1.html(durmins + ":" + dursecs); //Fill total duration time div
        if ($vid1[0].currentTime == $vid1[0].duration) { //when current time reached on total duration then   
            $vid1.unbind('click'); //unbind click event from video box
            $playBtn1.css('background', "url(" + IMAGES_PATH1 + "play_button_2.png) no-repeat"); //change playbtn icon
            $vidCntrPly1.css('background', "url(" + IMAGES_PATH1 + "reload.png) no-repeat scroll center center"); //change playbtn icon
            $vidCntrPly1.show(); //Display center play icon
        }
    };

    // function used for creating seek bar and binding time-update event
    var createSeek1 = function() {
        if ($vid1[0].readyState) { //when video is ready then add seek bar
            videoDuration1 = $vid1[0].duration;
            $seekSlider1.slider({
                value: 0,
                step: 0.01,
                orientation: "horizontal",
                range: "min",
                max: videoDuration1,
                animate: true,
                slide: function(e, ui) {
                    seekSliding1 = true;
                    $vid1[0].currentTime = ui.value;
                },
                stop: function(e, ui) {
                    seekSliding1 = false;
                    $vid1[0].currentTime = ui.value;
                }
            });
            $vid1.on("timeupdate", function(event) { //binding time update event
                seekBarUpdate1(); //update seek bar
            });
            $vidRdyFade1.hide('slow');
            $vidCntrPly1.show();
            seekBarUpdate1(); //called for displaying duration of the video 
        } else {
            //$vidRdyFade1.show('slow');
            setTimeout(createSeek1, 150);
        }
    };

    createSeek1();

    //When video is in progress then check the loaded percentage of video 
    $vid1.on('progress', function(e) {
        percentVidLoaded1 = null;
        // FF4+, Chrome
        if ($vid1[0] && $vid1[0].buffered && $vid1[0].buffered.length > 0 && $vid1[0].buffered.end && $vid1[0].duration) {
            percentVidLoaded1 = $vid1[0].buffered.end(0) / $vid1[0].duration;
        }
        /* Some browsers (e.g., FF3.6 and Safari 5) cannot calculate target.bufferered.end()
         *  to be anything other than 0. If the byte count is available we use this instead.
         *  Browsers that support the else if do not seem to have the bufferedBytes value and
         *  should skip to there.
         */
        else if ($vid1[0] && $vid1[0].bytesTotal != undefined && $vid1[0].bytesTotal > 0 && $vid1[0].bufferedBytes != undefined) {
            percentVidLoaded1 = $vid1[0].bufferedBytes / $vid1[0].bytesTotal;
        }
        if (percentVidLoaded1 !== null) {
            percentVidLoaded1 = 100 * Math.min(1, Math.max(0, percentVidLoaded1));
            percentVidLoaded1 = percentVidLoaded1 > VID_LOADED_WIDTH1 ? (fullScreenFlag1 ? VID_LOADED_WIDTH_FS1 : VID_LOADED_WIDTH1) : percentVidLoaded1;
            $('#ui-slider-range2').css('width', percentVidLoaded1 + '%');
        }
    });

    //Bind click event on Mute button 
    $muteBtn1.click(function() {
        if ($vid1[0].muted) { //If audio muted 
            $vid1[0].muted = false;
            $muteBtn1.html("Mute");
            newVolumeVal1 = lastVolumeVal1 = (lastVolumeVal1 == 0) ? parseFloat(lastVolumeVal1) + 0.50 : lastVolumeVal1;
            $volumeSlider1.slider('value', lastVolumeVal1);
        } else {
            $vid1[0].muted = true;
            $muteBtn1.html("Unmute");
            lastVolumeVal1 = $volumeSlider1.slider("value");
            newVolumeVal1 = 0;
            $volumeSlider1.slider('value', newVolumeVal1);
        }
        $muteBtn1.css('background', "url(" + IMAGES_PATH1 + volumeIcon1(newVolumeVal1) + ") no-repeat scroll 0 0 transparent"); //changed the icon of volume button
    });

    //This function is used for getting volume image icon on the basis of current volume value 
    var volumeIcon1 = function(volVal1) {
        if (volVal1 >= 0.7 && volVal1 <= 1) {
            return "volume_3.png";
        } else if (volVal1 >= 0.3 && volVal1 < 0.7) {
            return "volume_2.png";
        } else if (volVal1 >= 0.05 && volVal1 < 0.3) {
            return "volume_1.png";
        } else {
            return "mute_icon.png";
        }
    };

    // volume slider
    $volumeSlider1.slider({
        value: 1,
        orientation: "horizontal",
        range: "min",
        max: 1,
        step: 0.05,
        animate: true,
        slide: function(e, ui) {
            $muteBtn1.css('background', "url(" + IMAGES_PATH1 + volumeIcon1(ui.value) + ") no-repeat scroll 0 0 transparent");
            $vid1[0].muted = false;
            $vid1[0].volume = ui.value;
        }
    });

    //function used for taking the video player from normal to fullscreen or vice versa.
    var fullscreenFun1 = function() {
        if (fullScreenFlag1) { //checking is screen already on fullscreen then cancel the fullscreen mode
            if (document.exitFullscreen) { //for other browsers
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { //for mozilla
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) { //for chrome and safari
                document.webkitCancelFullScreen();
            }
            $vidPlayrBox1.css({width: VID_WIDTH1 + "px", height: ""}); //change the video player width on normal width height
            $vid1.css({width: "", height: ""});
			$(".lectr-lt").css({width: "74%", height: "710px", position:"relative"}); //take the video player box to 100%
			$(".lect-share").css({display:"block"}); //take the video player box to 100%
            fullScreenFlag1 = 0; //change the fullScreen  Flag value  
            $fulScrenBtn1.css('background', "url(" + IMAGES_PATH1 + "full_screen_icon.png) no-repeat scroll 0 0 transparent"); //changed the fullscreen icon
            $(".seekslider-outer1").css('width', SEEKBAR_OUTR_WIDTH1 + "%");
            if (percentVidLoaded1 == VID_LOADED_WIDTH1) { //if video 100% buffered then set their normal screen width 
                $('#ui-slider-range2-1').css('width', VID_LOADED_WIDTH1 + '%');
            }
        } else {
            if ($vid1[0].requestFullScreen) { // check the fullscreen request for other browsers
                $vidPlayrBox1[0].requestFullScreen();
            } else if ($vid1[0].webkitRequestFullScreen) { // check the fullscreen request for mozilla
                $vidPlayrBox1[0].webkitRequestFullScreen();
            } else if ($vid1[0].mozRequestFullScreen) { // check the fullscreen request for chrome and safari
                $vidPlayrBox1[0].mozRequestFullScreen();
            }
            $vidPlayrBox1.css({width: "100%", height: "100%"}); //take the video player box to 100%
			$(".lectr-lt").css({width: "100%", height: "100%", position:"absolute"}); //take the video player box to 100%
			$(".lect-share").css({display:"none"}); //take the video player box to 100%
            $vid1.css({width: "100%", height: "100%"});
            fullScreenFlag1 = 1;
            $fulScrenBtn1.css('background', "url(" + IMAGES_PATH1 + "minimize_fullscreen.png) no-repeat scroll 0 0 transparent");
            $(".seekslider-outer1").css('width', SEEKBAR_OUTR_WIDTH_FS1 + "%");
            if (percentVidLoaded1 == VID_LOADED_WIDTH1) {//if video 100% buffered then set their fullscreen screen width 
                $('#ui-slider-range2-1').css('width', VID_LOADED_WIDTH_FS1 + '%');
            }
        }
    };
    $fulScrenBtn1.click(function() { //bind click event on fullscreen button
        fullscreenFun1();
    });

    document.addEventListener("fullscreenchange", function() { //adding fullscreen change event listener 
        if (!document.fullscreen && fullScreenFlag1) {
            fullscreenFun1();
        }
    }, false);

    document.addEventListener("mozfullscreenchange", function() { //adding fullscreen change event listener for mozilla
        if (!document.mozFullScreen && fullScreenFlag1) {
            fullscreenFun1();
        }
    }, false);

    document.addEventListener("webkitfullscreenchange", function() { //adding fullscreen change event listener for chrome
        if (!document.webkitIsFullScreen && fullScreenFlag1) {
            fullscreenFun1();
        }
    }, false);

    //while loading video any error occured then display error corresponing to their error code
    /*$vid.error(function(e, ui) {
        switch (e.target.error.code) {
            case e.target.error.MEDIA_ERR_ABORTED:
                alert('You aborted the video playback.');
                break;
            case e.target.error.MEDIA_ERR_NETWORK:
                alert('A network error caused the video download to fail part-way.');
                break;
            case e.target.error.MEDIA_ERR_DECODE:
                alert('The video playback was aborted due to a corruption problem or because the video used features your browser did not support.');
                break;
            case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
                alert('The video could not be loaded, either because the server or network failed or because the format is not supported.');
                break;
            default:
                alert('An unknown error occurred.');
                break;
        }
        //alert("Error Code : "+event.target.error.code);
    });*/
});
