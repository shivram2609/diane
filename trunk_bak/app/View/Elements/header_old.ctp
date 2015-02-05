<div class="header">
	<div class="wrapper">

		<a href="<?php echo SITE_LINK; ?>" class="logo__ header-logo__" title="Institute of Technology"></a>
		<ul class="top_links">
			
		</ul>
		<div class="right_header" style="width: 116%;">
			<a href="<?php echo $this->Html->url("/"); ?>" class="btn2" style="float:left;">Home</a>
		<?php if (!$this->Session->read("Auth.User.id")) { ?>
			<a href="<?php echo $this->Html->url("/signup"); ?>" id="signup" class="btn2">Sign Up</a>
			<a href="<?php echo $this->Html->url("/login"); ?>" id="signin" class="btn2">Sign In</a>
			<a href="<?php echo $this->Html->url("/view-courses"); ?>" title="Courses" class="btn2">Courses</a>
			<a href="<?php echo $this->Html->url("/login"); ?>" id="mycourse" class="btn2">My Courses</a>
			<a href="<?php echo $this->Html->url("/login"); ?>" id="createcourse" class="btn2">Teach Online</a>
		<?php } else { ?>
		<?php 
			echo $this->Html->link("Profile",array("controller"=>"profile","action"=>$this->Session->read("Auth.User.Userdetail.user_id"),$this->Common->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))),array("class"=>"btn2"));
			?>
			<a href="<?php echo $this->Html->url("/view-courses"); ?>" title="Courses" class="btn2">Courses</a>
			<a href="<?php echo $this->Html->url("/mycourses"); ?>" title="My Courses" class="btn2">My Courses</a>
			<a href="<?php echo $this->Html->url("/course-manage/create"); ?>" title="Teach Online" class="btn2">Teach Online</a>
			<?php
			if (!$this->Session->read("FB.Me.id")) {
				echo $this->Html->link("Change Password","/changepassword",array("class"=>"btn2")); 
			 }
		 ?>
			<?php 
						if (!$this->Session->read("FB.Me.id")) {
							echo $this->Html->link("Logout","/users/logout",array("class"=>"btn2"));
						} else { 
							echo $this->Facebook->logout(array('label' => 'Logout', 'redirect' => array("controller"=>"users","action"=>'logout'),"class"=>"btn2")); 
						}  
					 ?>
		<?php } ?>
		<!--a class="btn2" href="<?php //echo $this->Html->url('/course-manage/create'); ?>">Create a Course</a>
		<a class="btn2" href="<?php //echo $this->Html->url('/mycourses'); ?>">My Courses</a-->
		</div>
	</div>
</div>

