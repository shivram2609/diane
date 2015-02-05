<div class="container">
			<?php echo $this->element('coursesLeft');?>
			<section class="right-panel">
				<h1>Live Sessions<br />
				<span>Supplement your courses with live meetings.</span>
				</h1>
				<div class="live-sess-cont">
					<h2>Upcoming Sessions</h2>
					<a href="#" id="joinSession" title="Schedule A New Live Session" class="live-session-btn">Schedule A New Live Session</a>
									
										
				</div>
			</section>
		
	</div>
</div>
  <!--Live Session Poup-->
 
 <div class="live-sess-popup" style="display:none">
 <h2>Schedule a new live session <span class="close-icon"><a href="#" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="form">
	<form> 
		<input type="text" name="Title" onblur="if(this.value == ''){this.value= this.defaultValue;}" onfocus="if(this.value == 'Title') { this.value = ''; }" value="Title" />
		<label>Date:</label>
		<input type="text" name="date" class="date"  onblur="if(this.value == ''){this.value= this.defaultValue;}" onfocus="if(this.value == 'Select Date') { this.value = ''; }" value="Select Date"  />
		<div class="lft">
			<label>From:</label>
		<input type="text" name="from" value=""  />
		</div>
		
		<div class="rt">
			<label>To:</label>
		<input type="text" name="to" value=""  />
		</div>
		<textarea rows="4" cols="50" name="Description" onblur="if(this.value == ''){this.value= this.defaultValue;}" onfocus="if(this.value == 'Description') { this.value = ''; }">Description</textarea>
		
		<div class="clear-fix"></div>
		<p class="txt-center"><input type="submit" class="save-btn" name="" value="Save"></p>
	</form>
	</div>
 </div> 
   <div class="blackOpcty_quote" style="display:none"></div>
<!--Live Session Poup-->

<script>
	$(document).ready(function(){
		$("#joinSession").click(function(e){
			$('.live-sess-popup').show();
			$('.blackOpcty_quote').show();
		});
		$('#closeMe').click(function(){
			$('.blackOpcty_quote').hide();
			$('.live-sess-popup').hide();
		});
	});
</script>
