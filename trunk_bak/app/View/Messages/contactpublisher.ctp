<div class="profile_section">
	<?php echo $this->element("toplinks"); ?>
	<div class="message_wrapper">
		<div class="top_msg_section">
			<div class="message_list_bx">
				<?php echo $this->element("messageleft"); ?>
				<div class="view_message_bx new_message">
					<?php	if(!isset($error)) {
								echo $this->Form->create("Message");
					?>
						<div class="view_msg_top_strip">
							<span class="view_msg_heading">New Message</span>
						</div>
						<div class="new_msg_bx">
							<?php echo $this->Form->input("to",array("value"=>"to: ".(isset($recvname)?$recvname:($application['Userdetail']['first_name'].' '.$application['Userdetail']['last_name'])),"readonly","div"=>false,"label"=>false,"class"=>"new_msg_input")); ?>
							<?php echo $this->Form->input("subject",array("div"=>true,"label"=>false,"class"=>"new_msg_input","placeholder"=>"Subject")); ?>
							<?php echo $this->Form->input("message",array("div"=>'textareamsg',"label"=>false,"placeholder"=>"Message")); ?>
							<span class="msg_bgn_bx">	
								<?php echo $this->Form->submit("Send",array("class"=>"savebtn send_btn submitwidth","div"=>false,"label"=>false)); ?>
								<a class="btn3" href="<?php echo $this->Html->url("/campaignrequests"); ?>">Cancel</a>
							</span>
						</div>
					<?php	echo $this->Form->end(); } ?>
				</div>
			</div>
		</div>
		
	</div>
</div>
