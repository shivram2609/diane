var $vid, $playBtn, $seekSlider, $curTimeTxt, $durTimeTxt, $muteBtn, $volumeSlider, $fulScrenBtn, $vidOutrBox, $vidPlayrBox, $lightShadow,
        $lightBtn, $vidRdyFade, $vidCntrPly, seekSliding, videoDuration, fullScreenFlag = 0, lightIcon, lastVolumeVal, newVolumeVal, percentVidLoaded;

var IMAGES_PATH = BASE_URL + "/img/mashup/", VID_LOADED_WIDTH = 98, VID_LOADED_WIDTH_FS = 99.7, VID_WIDTH = "350px", VID_HEIGHT = 480, SEEKBAR_OUTR_WIDTH = 30, SEEKBAR_OUTR_WIDTH_FS = 72, VID_PLYR_FS_WDTH = "100%", VID_PLYR_FS_HEGHT = "100%", VID_OTR_BX_WDTH = "630px"; //constants

var mrkdMshupPonts = {};

$(document).ready(function() {
    $vid = $("#my_video");
    $playBtn = $("#playpausebtn");
    $seekSlider = $("#seekslider");
    $curTimeTxt = $("#curtimetext");
    $durTimeTxt = $("#durtimetext");
    $muteBtn = $("#mutebtn");
    $volumeSlider = $("#volumeslider");
    $fulScrenBtn = $("#fullscreenbtn");
    $vidOutrBox = $('.video_outer');
    $vidPlayrBox = $('#video_player_box');
    $lightShadow = $('#shadow');
    $lightBtn = $('#dimlight');
    $vidRdyFade = $('#video_ready_fade');
    $vidCntrPly = $('#video_center_play');
    $lightShadow.css("height", $(document).height()).hide();
    // play-pause function
    var vidPlay = function() {
        $vid.unbind('click').click(vidPlay);
        if ($vid[0].paused) {
            $vidCntrPly.hide();
            $vid[0].play();
            $playBtn.css('background', "url(" + IMAGES_PATH + "pause_button.png) no-repeat");
        } else {
            $vid[0].pause();
            $playBtn.css('background', "url(" + IMAGES_PATH + "play_button_2.png) no-repeat");
        }
    };

    $playBtn.click(vidPlay); //Bind click event on play button
    $vidCntrPly.click(vidPlay); //Bind click event on center play button

    //Light dim and on method
    $lightBtn.click(function() {
        if ($lightShadow.is(":visible")) {
            $lightShadow.fadeOut('slow');
            lightIcon = "radial_light.png";
        } else {
            $lightShadow.fadeIn('slow');
            lightIcon = "bulb_click.png";
        }
        $lightBtn.css('background', "url(" + IMAGES_PATH + lightIcon + ") no-repeat scroll 0 -1px transparent");
    });

    // function used for creating seek bar and binding time-update event
    var createSeek = function() {
        if ($vid[0].readyState) { //when video is ready then add seek bar
            videoDuration = $vid[0].duration;
            $seekSlider.slider({
                value: 0,
                step: 0.01,
                orientation: "horizontal",
                range: "min",
                max: videoDuration,
                animate: true,
                slide: function(e, ui) {
                    seekSliding = true;
                    $vid[0].currentTime = ui.value;
                },
                stop: function(e, ui) {
                    seekSliding = false;
                    $vid[0].currentTime = ui.value;
                }
            });
            $vid.on("timeupdate", function(event) { //binding time update event
                seekBarUpdate(); //update seek bar
            });
            $vidRdyFade.hide('slow');
            $vidCntrPly.show();
            seekBarUpdate(); //called for displaying duration of the video 
            loadMashupImages();
        } else {
            //$vidRdyFade.show('slow');
            setTimeout(createSeek, 150);
        }
    };
	setTimeout(createSeek, 150);

    //When video is in progress then check the loaded percentage of video 
    $vid.on('progress', function(e) {
        percentVidLoaded = null;
        // FF4+, Chrome
        if ($vid[0] && $vid[0].buffered && $vid[0].buffered.length > 0 && $vid[0].buffered.end && $vid[0].duration) {
            percentVidLoaded = $vid[0].buffered.end(0) / $vid[0].duration;
        }
        /* Some browsers (e.g., FF3.6 and Safari 5) cannot calculate target.bufferered.end()
         *  to be anything other than 0. If the byte count is available we use this instead.
         *  Browsers that support the else if do not seem to have the bufferedBytes value and
         *  should skip to there.
         */
        else if ($vid[0] && $vid[0].bytesTotal != undefined && $vid[0].bytesTotal > 0 && $vid[0].bufferedBytes != undefined) {
            percentVidLoaded = $vid[0].bufferedBytes / $vid[0].bytesTotal;
        }
        if (percentVidLoaded !== null) {
            percentVidLoaded = 100 * Math.min(1, Math.max(0, percentVidLoaded));
            percentVidLoaded = percentVidLoaded > VID_LOADED_WIDTH ? (fullScreenFlag ? VID_LOADED_WIDTH_FS : VID_LOADED_WIDTH) : percentVidLoaded;
           // $('#ui-slider-range2').css('width', percentVidLoaded + '%');
        }
    });

    //Bind click event on Mute button 
    $muteBtn.click(function() {
        if ($vid[0].muted) { //If audio muted 
            $vid[0].muted = false;
            $muteBtn.html("Mute");
            newVolumeVal = lastVolumeVal = (lastVolumeVal == 0) ? parseFloat(lastVolumeVal) + 0.50 : lastVolumeVal;
            $volumeSlider.slider('value', lastVolumeVal);
        } else {
            $vid[0].muted = true;
            $muteBtn.html("Unmute");
            lastVolumeVal = $volumeSlider.slider("value");
            newVolumeVal = 0;
            $volumeSlider.slider('value', newVolumeVal);
        }
        $muteBtn.css('background', "url(" + IMAGES_PATH + volumeIcon(newVolumeVal) + ") no-repeat scroll 0 0 transparent"); //changed the icon of volume button
    });

    //This function is used for getting volume image icon on the basis of current volume value 
    var volumeIcon = function(volVal) {
        if (volVal >= 0.7 && volVal <= 1) {
            return "volume_3.png";
        } else if (volVal >= 0.3 && volVal < 0.7) {
            return "volume_2.png";
        } else if (volVal >= 0.05 && volVal < 0.3) {
            return "volume_1.png";
        } else {
            return "mute_icon.png";
        }
    };

    // volume slider
    $volumeSlider.slider({
        value: 1,
        orientation: "horizontal",
        range: "min",
        max: 1,
        step: 0.05,
        animate: true,
        slide: function(e, ui) {
            $muteBtn.css('background', "url(" + IMAGES_PATH + volumeIcon(ui.value) + ") no-repeat scroll 0 0 transparent");
            $vid[0].muted = false;
            $vid[0].volume = ui.value;
        }
    });

    //function used for taking the video player from normal to fullscreen or vice versa.
    var fullscreenFun = function() {
        if (fullScreenFlag) { //checking is screen already on fullscreen then cancel the fullscreen mode
            if (document.exitFullscreen) { //for other browsers
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { //for mozilla
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) { //for chrome and safari
                document.webkitCancelFullScreen();
            }
			$vidOutrBox.css({width: VID_OTR_BX_WDTH, height: ""});
            $vidPlayrBox.css({width: VID_WIDTH, height: ""}); //change the video player width on normal width height
            $vid.css({width: "", height: ""});
            $("#" + prviwImgDivId).css({width: PRVIEW_IMG_DIV_WDTH, height: PRVIEW_IMG_DIV_HEGHT});
            fullScreenFlag = 0; //change the fullScreen  Flag value  
            $fulScrenBtn.css('background', "url(" + IMAGES_PATH + "full_screen_icon.png) no-repeat scroll 0 0 transparent"); //changed the fullscreen icon
            $(".seekslider-outer").css('width', SEEKBAR_OUTR_WIDTH + "%");
            /*if (percentVidLoaded == VID_LOADED_WIDTH) { //if video 100% buffered then set their normal screen width 
                $('#ui-slider-range2').css('width', VID_LOADED_WIDTH + '%');
            }*/
            UprPnlTtlFitdImgs = UprPnlTtlFitdImgsTmp;
        } else {
            if ($vid[0].requestFullScreen) { // check the fullscreen request for other browsers
                $vidPlayrBox[0].requestFullScreen();
            } else if ($vid[0].webkitRequestFullScreen) { // check the fullscreen request for mozilla
                $vidPlayrBox[0].webkitRequestFullScreen();
            } else if ($vid[0].mozRequestFullScreen) { // check the fullscreen request for chrome and safari
                $vidPlayrBox[0].mozRequestFullScreen();
            }
			$vidOutrBox.css({width: "100%", height: "100%"});
            $vidPlayrBox.css({width: "100%", height: "100%"}); //take the video player box to 100%
            $vid.css({width: VID_PLYR_FS_WDTH, height: VID_PLYR_FS_HEGHT});
            $("#" + prviwImgDivId).css({width: PRVIEW_IMG_DIV_WDTH_FS, height: PRVIEW_IMG_DIV_HEGHT_FS});
            fullScreenFlag = 1;
            $fulScrenBtn.css('background', "url(" + IMAGES_PATH + "minimize_fullscreen.png) no-repeat scroll 0 0 transparent");
            $(".seekslider-outer").css('width', SEEKBAR_OUTR_WIDTH_FS + "%");
            UprPnlTtlFitdImgs = UprPnlTtlFitdImgsFs;
            /*if (percentVidLoaded == VID_LOADED_WIDTH) {//if video 100% buffered then set their fullscreen screen width 
                $('#ui-slider-range2').css('width', VID_LOADED_WIDTH_FS + '%');
            }*/
        }
    };
    $fulScrenBtn.click(function() { //bind click event on fullscreen button
        fullscreenFun();
    });

    document.addEventListener("fullscreenchange", function() { //adding fullscreen change event listener 
        if (!document.fullscreen && fullScreenFlag) {
            fullscreenFun();
        }
    }, false);

    document.addEventListener("mozfullscreenchange", function() { //adding fullscreen change event listener for mozilla
        if (!document.mozFullScreen && fullScreenFlag) {
            fullscreenFun();
        }
    }, false);

    document.addEventListener("webkitfullscreenchange", function() { //adding fullscreen change event listener for chrome
        if (!document.webkitIsFullScreen && fullScreenFlag) {
            fullscreenFun();
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
Array.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key))
            size++;
    }
    return size;
};
/* Method for checking whether the images are fully loaded or not.  */
var lodImgsProcesing = function(divId, prcsngDivId) {
    var nImages = $("#"+divId).length;
    var loadCounter = 0;
    $("#"+divId+" img").one("load", function() {
        loadCounter++;
        if (nImages == loadCounter) {
            $("#"+prcsngDivId).hide();
        }
    }).each(function() {
        // attempt to defeat cases where load event does not fire
        // on cached images
        if (this.complete) {
            $(this).trigger("load");
        }
    });
};
