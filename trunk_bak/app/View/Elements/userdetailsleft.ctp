<aside class="left-container1">
<div  class="left-container">
<div class="left-bar">
	<div class="outer_pro_img">
		<div class="pro_img">
			<?php 
			// use thumb path from helper
			$profileImgPathThumb1 = (($this->Session->read("Auth.User.Userdetail.image") && file_exists(WWW_ROOT.$this->Session->read("Auth.User.Userdetail.image")))?$this->Session->read("Auth.User.Userdetail.image"): "/img/no-img.png");
			$profileImgThumb1 = $this->Common->getImageName($profileImgPathThumb1, MediumProfileImagePrefix);
			echo $this->Html->image($profileImgThumb1,array("alt"=>$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"),"width"=>"168px","height"=>"168px"));
			
			?>
			<!-- <img src="img/img_001.jpg" alt="" />-->
		</div>
		<span class="heading-name" ><?php echo (!empty($this->data['Userdetail']['first_name'])?ucwords($this->data['Userdetail']['first_name']):'').' '.(!empty($this->data['Userdetail']['last_name'])?ucwords($this->data['Userdetail']['last_name']):'');?></span>
		<p><?php echo (!empty($this->data['Userdetail']['heading'])?$this->data['Userdetail']['heading']:'');?></p>
	</div>	
</div>
</div>
<div class="clear-fix">&nbsp;</div>
<div  class="left-container">
<div class="left-bar">	
	<ul>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile') echo  'selected'?>"><a href="<?php echo $this->Html->url("/editprofile"); ?>" title="Profile">Profile</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile_photo') echo  'selected'?>"><a href="<?php echo $this->Html->url("/profilepic"); ?>" title="Photo">Photo</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile_account') echo  'selected'?>"><a href="<?php echo $this->Html->url("/account"); ?>" title="Account Settings">Account Settings</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'premium_instructor') echo  'selected'?>"><a href="<?php echo $this->Html->url("/paypal-account"); ?>" title="Account">Paypal Account</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile_privacy') echo  'selected'?>"><a href="<?php echo $this->Html->url("/privacy"); ?>" title="Privacy Settings">Privacy Settings</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile_notification') echo  'selected'?>"><a href="<?php echo $this->Html->url("/notifications"); ?>" title="Notifications">Notifications</a></li>
		<li class="<?php if($this->params['controller'] == 'userdetails' && $this->params['action'] == 'edit_profile_dangerzone') echo  'selected'?>"><a href="<?php echo $this->Html->url("/deleteaccount"); ?>" title="Delete Account">Delete Account</a></li>
	</ul>
	</div>
<div>
</aside>
