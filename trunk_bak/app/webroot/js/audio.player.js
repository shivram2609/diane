var $adio, $playBtn, $seekSlider, $curTimeTxt, $durTimeTxt, $muteBtn, $volumeSlider, $audioPlayrBox, $audioRdyFade, seekSliding, audioDuration, lastVolumeVal, newVolumeVal, percentAudioLoaded;

var IMAGES_PATH = BASE_URL + "/img/audio_player/", AUDIO_LOADED_WIDTH = 98, AUDIO_WIDTH = 540, SEEKBAR_OUTR_WIDTH = 35; //constants

$(document).ready(function(){
	$audio = $("#my_audio");
	$playBtn = $("#playpausebtn");
	$seekSlider = $("#seekslider");
	$curTimeTxt = $("#curtimetext");
	$durTimeTxt = $("#durtimetext");
	$muteBtn = $("#mutebtn");
	$volumeSlider = $("#volumeslider");
	$audioPlayrBox = $('#audio_player_box');
	$audioRdyFade = $('#audio_ready_fade');
	// play-pause function
	var audioPlay = function() {
		$audio.unbind('click').click(audioPlay);
		if ($audio[0].paused) {
			$audio[0].play();
			$playBtn.css('background',"url("+IMAGES_PATH+"pause_button.png)");
		} else {
			$audio[0].pause();
			$playBtn.css('background',"url("+IMAGES_PATH+"play_button_2.png)");
		}
	};
	
	$playBtn.click(audioPlay); //Bind click event on play button

	//Seek bar update method
	var seekBarUpdate = function() {
		if (!seekSliding) {
			$seekSlider.slider("value", $audio[0].currentTime); //update seek bar slider value
		}
		var curmins = Math.floor($audio[0].currentTime / 60);
		var cursecs = Math.floor($audio[0].currentTime - curmins * 60);
		var durmins = Math.floor($audio[0].duration / 60);
		var dursecs = Math.floor($audio[0].duration - durmins * 60);
		cursecs = cursecs < 10 ? "0" + cursecs : cursecs;
		dursecs = dursecs < 10 ? "0" + dursecs : dursecs;
		curmins = curmins < 10 ? "0" + curmins : curmins;
		durmins = durmins < 10 ? "0" + durmins : durmins;
		$curTimeTxt.html(curmins + ":" + cursecs); //Update current time div
		$durTimeTxt.html(durmins + ":" + dursecs); //Fill total duration time div
		if($audio[0].currentTime == $audio[0].duration) { //when current time reached on total duration then   
			$playBtn.css('background',"url("+IMAGES_PATH+"play_button_2.png)"); //change playbtn icon
		}
	};

	// function used for creating seek bar and binding time-update event
	var createSeek = function() {
		if ($audio[0].readyState) { //when audio is ready then add seek bar
			audioDuration = $audio[0].duration;
			$seekSlider.slider({
				value : 0,
				step : 0.01,
				orientation : "horizontal",
				range : "min",
				max : audioDuration,
				animate : true,
				slide : function(e, ui) {
					seekSliding = true;
					$audio[0].currentTime = ui.value;
				},
				stop : function(e, ui) {
					seekSliding = false;
					$audio[0].currentTime = ui.value;
				}
			});		
			$audio.on("timeupdate", function(event){ //binding time update event
				event.preventDefault();
				seekBarUpdate(); //update seek bar
			});
			$audioRdyFade.hide('slow'); 
			seekBarUpdate(); //called for displaying duration of the audio 
		} else {
			//$audioRdyFade.show('slow'); 
			setTimeout(createSeek, 150);
		}
	};

	createSeek();

	//When audio is in progress then check the loaded percentage of audio 
	$audio.on('progress', function(e) {
		percentAudioLoaded = null;
		// FF4+, Chrome
		if ($audio[0] && $audio[0].buffered && $audio[0].buffered.length > 0 && $audio[0].buffered.end && $audio[0].duration) {
			percentAudioLoaded = $audio[0].buffered.end(0) / $audio[0].duration;
		} 
		/* Some browsers (e.g., FF3.6 and Safari 5) cannot calculate target.bufferered.end()
		*  to be anything other than 0. If the byte count is available we use this instead.
		*  Browsers that support the else if do not seem to have the bufferedBytes value and
		*  should skip to there.
		*/
		else if ($audio[0] && $audio[0].bytesTotal != undefined && $audio[0].bytesTotal > 0 && $audio[0].bufferedBytes != undefined) {
			percentAudioLoaded = $audio[0].bufferedBytes / $audio[0].bytesTotal;
		}
		if (percentAudioLoaded !== null) {
			percentAudioLoaded = 100 * Math.min(1, Math.max(0, percentAudioLoaded));
			percentAudioLoaded = percentAudioLoaded > AUDIO_LOADED_WIDTH ? AUDIO_LOADED_WIDTH : percentAudioLoaded; 
			$('#ui-slider-range2').css('width', percentAudioLoaded+'%');
		}
	});		

	//Bind click event on Mute button 
	$muteBtn.click(function(){
		if ($audio[0].muted) { //If audio muted 
			$audio[0].muted = false;
			$muteBtn.html("Mute");
			newVolumeVal = lastVolumeVal = (lastVolumeVal == 0)?parseFloat(lastVolumeVal)+0.50:lastVolumeVal;  
			$volumeSlider.slider('value', lastVolumeVal);
		} else {
			$audio[0].muted = true;
			$muteBtn.html("Unmute");
			lastVolumeVal = $volumeSlider.slider("value");
			newVolumeVal = 0;
			$volumeSlider.slider('value', newVolumeVal);
		}
		$muteBtn.css('background',"url("+IMAGES_PATH+volumeIcon(newVolumeVal)+") no-repeat scroll 0 0 transparent"); //changed the icon of volume button
	});

	//This function is used for getting volume image icon on the basis of current volume value 
	var volumeIcon = function(volVal) {
		if(volVal >=  0.7 && volVal <= 1) {
			return "volume_3.png";
		} else if(volVal >=  0.3 && volVal < 0.7) {
			return "volume_2.png";
		} else if(volVal >=  0.05 && volVal < 0.3) {
			return "volume_1.png";
		} else {
			return "mute_icon.png";
		}
	};
	
	// volume slider
	$volumeSlider.slider({
		value : 1,
		orientation : "horizontal",
		range : "min",
		max : 1,
		step : 0.05,
		animate : true,
		slide : function(e, ui) {
			$muteBtn.css('background',"url("+IMAGES_PATH+volumeIcon(ui.value)+") no-repeat scroll 0 0 transparent");
			$audio[0].muted = false;
			$audio[0].volume = ui.value;
		}
	});

	//while loading audio any error occured then display error corresponing to their error code
	$audio.error(function(e,ui) {
		switch (e.target.error.code) {
		 case e.target.error.MEDIA_ERR_ABORTED:
		   alert('You aborted the audio playback.');
		   break;
		 case e.target.error.MEDIA_ERR_NETWORK:
		   alert('A network error caused the audio download to fail part-way.');
		   break;
		 case e.target.error.MEDIA_ERR_DECODE:
		   alert('The audio playback was aborted due to a corruption problem or because the audio used features your browser did not support.');
		   break;
		 case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
		   alert('The audio could not be loaded, either because the server or network failed or because the format is not supported.');
		   break;
		 default:
		   alert('An unknown error occurred.');
		   break;
	   }
	   //alert("Error Code : "+event.target.error.code);
	});
});
