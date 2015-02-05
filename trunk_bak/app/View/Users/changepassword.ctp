<div class="business_campaign_box">

	<div class="right_section_campaign">
		<h1 class="heading2">Change Password</h1>
		<?php echo $this->Session->flash(); ?>
		<div class="changepassword_bx">
		<?php echo $this->Form->create("User"); ?>
			<?php echo $this->Form->input("currentpassword",array("type"=>'password',"class"=>'chng_pswd_fld','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Current Password')); ?>
			<?php echo $this->Form->input("password",array("type"=>'password',"class"=>'chng_pswd_fld','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'New Password')); ?>
			<?php echo $this->Form->input("confirmpassword",array("type"=>'password',"class"=>'chng_pswd_fld','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Confirm Password')); ?>
			<?php echo $this->Form->input("id",array("type"=>'hidden','label'=>false,"value"=>$this->Session->read("Auth.User.id"))); ?>
			<span class="buttonbox">
				<!--a href="#"class="btn3">Cancel</a-->
				<?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'savebtn submitwidth')); ?>
			</span>
		<?php echo $this->Form->end(); ?>
		</div>	
		</div>
	</div>
</div>
