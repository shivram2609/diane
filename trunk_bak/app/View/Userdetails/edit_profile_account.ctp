<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft');?>
	<section class="right-panel">
		<div class="account-cont">
			<h1>Account Settings</h1><br>
			<span>&nbsp;</span>
			<?php echo $this->Form->create('User',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
			<div class="tabs_outer b_b">
				<div class="row">
			<div class="category-box-text">
				<h2>Email Account</h2>
			</div>
					<div class="left"><br />
					<?php if($this->Session->read("Auth.User.loginfrom") == 'Twitter' ) {
						if(!$this->Session->read("Auth.User.Userdetail.email") ) { 
							echo empty($this->data['Userdetail']['email'])?"Please enter your email":"Your email address is ".$this->data['Userdetail']['email'];
						?>
							<?php echo $this->Form->input('Userdetail.email',array("placeholder"=>empty($this->data['Userdetail']['email'])?"Please enter your email":"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p")); ?>
						<?php } else { 
						echo "Your email address is ".$this->data['Userdetail']['email'];
						?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "readonly"=>"readonly")); ?>
						<?php } ?>
					<?php } elseif($this->Session->read("Auth.User.loginfrom") == 'FB') { 
					echo "Your email address is ".$this->data['User']['username'];
					?>
						<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['User']['username'], "div"=>false,"label"=>false,"type"=>"text", "readonly")); ?>
					<?php } else { 
						if($this->Session->read("Auth.User.loginfrom") == 'Twitter') { 
						echo "Your email address is ".$this->data['Userdetail']['email'];
						?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "readonly"=>"readonly","disabled")); ?>
						<?php } else { 
						echo "Your email address is ".$this->data['User']['username'];
						?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['User']['username'], "div"=>false,"label"=>false,"type"=>"text", "readonly"=>"readonly","disabled")); ?>
						<?php } ?>
						</div>
						</div>
					<div class="row">
						<div class="category-box-text1">
							<br>
							<h2>Account Password</h2>
						</div>
						<div class="left">
						<?php echo $this->Form->input("currentpassword",array("type"=>'password','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Enter Current Password')); ?>
						<?php echo $this->Form->input("password",array("type"=>'password','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Enter New Password')); ?>
						<?php echo $this->Form->input("confirmpassword",array("type"=>'password','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Re-type New Password')); ?>
						<?php echo $this->Form->input("id",array("type"=>'hidden','label'=>false,"value"=>$this->Session->read("Auth.User.id"))); ?>
					<?php } ?>
					
					<?php if($this->Session->read("Auth.User.loginfrom") == 'Twitter' && !$this->Session->read("Auth.User.Userdetail.email")) { ?>
				<p><?php echo $this->Form->Submit("Update",array('label'=>false,'div'=>false,'class'=>'save_btn l_b_p')); ?></p>
			<?php } elseif($this->Session->read("Auth.User.loginfrom") == 'FB' || $this->Session->read("Auth.User.loginfrom") == 'Twitter') {
			?>
				
			<?php	
			} else { ?>
				<p><?php echo $this->Form->Submit("Change Password",array('label'=>false,'div'=>false,'class'=>'save_btn l_b_p')); ?></p>
				</div>
					</div>
				</div>
			</div>
			
			<?php } ?>
		</div>
	</section>		
</div>
