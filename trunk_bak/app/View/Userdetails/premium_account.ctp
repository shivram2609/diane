<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft');?>
	<section class="right-panel">
		<div class="privacy">
			<h1>
				Account<br>
				<span>Edit your account settings and change your password here.</span>
			</h1>
			<?php echo $this->Form->create('User',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
			<div class="tabs_outer b_b">
				<div id="tabs">
					<label class="des">Email</label>	
					<?php if($this->Session->read("Auth.User.loginfrom") == 'Twitter' ) {
						if(!$this->Session->read("Auth.User.Userdetail.email") ) { ?>
							<?php echo $this->Form->input('Userdetail.email',array("placeholder"=>empty($this->data['Userdetail']['email'])?"Please enter your email":"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p")); ?>
						<?php } else { ?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p", "readonly"=>"readonly")); ?>
						<?php } ?>
					<?php } elseif($this->Session->read("Auth.User.loginfrom") == 'FB') { ?>
						<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['User']['username'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p","readonly")); ?>
					<?php } else { 
						if($this->Session->read("Auth.User.loginfrom") == 'Twitter') { ?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['Userdetail']['email'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p", "readonly"=>"readonly","disabled")); ?>
						<?php } else { ?>
							<?php echo $this->Form->input('usernames',array("placeholder"=>"Your email address is ".$this->data['User']['username'], "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p", "readonly"=>"readonly","disabled")); ?>
						<?php } ?>
					<label class="des">Password</label>
						<?php echo $this->Form->input("currentpassword",array("type"=>'password',"class"=>'access p_b','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Enter Current Password')); ?>
						<?php echo $this->Form->input("password",array("type"=>'password',"class"=>'access p_b','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Enter New Password')); ?>
						<?php echo $this->Form->input("confirmpassword",array("type"=>'password',"class"=>'access p_b','label'=>false,'div'=>'chng_pswd_flds','placeholder'=>'Re-type New Password')); ?>
						<?php echo $this->Form->input("id",array("type"=>'hidden','label'=>false,"value"=>$this->Session->read("Auth.User.id"))); ?>
					<?php } ?>
				</div>
			</div>
			<?php if($this->Session->read("Auth.User.loginfrom") == 'Twitter' && !$this->Session->read("Auth.User.Userdetail.email")) { ?>
				<p class="txt-center"><?php echo $this->Form->Submit("Update",array('label'=>false,'div'=>false,'class'=>'save_btn l_b_p')); ?></p>
			<?php } elseif($this->Session->read("Auth.User.loginfrom") == 'FB' || $this->Session->read("Auth.User.loginfrom") == 'Twitter') {
			?>
				
			<?php	
			} else { ?>
				<p class="txt-center"><?php echo $this->Form->Submit("Change Password",array('label'=>false,'div'=>false,'class'=>'save_btn l_b_p')); ?></p>
			<?php } ?>
		</div>
	</section>		
</div>
