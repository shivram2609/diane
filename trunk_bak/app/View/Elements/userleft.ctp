<ul class="left_nav">
	<li><span class="my-campaign-icon"></span><a href="<?php echo $this->Html->url("/campaigns"); ?>" >My Campaign</a></li>
	<li class="my_profile"><span class="my-profile"></span><?php
					echo $this->Html->link("My Profile",array("controller"=>"profile","action"=>$this->Session->read("Auth.User.Userdetail.user_id"),$this->Common->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))));
					?></li>
	<li class="chng_psswd"><span class="change-pswd"></span><a href="<?php echo $this->Html->url("/changepassword"); ?>" class="active">Change Password</a></li>
</ul>
