<header>
<div class="header">
<div class="logo"><a href="<?php echo $this->Html->url("/"); ?>" title="1337 Institute of Technology"><?php echo $this->Html->image("/img/logo.png",array("alt"=>"1337 Institute of Thechnology","width"=>"557","height"=>"55")); ?></a></div>
<div class="right_header">
<?php if($this->session->read("Auth.User.id")) { ?>
	<div class="acc_drpdwn my-account ">
		
		<span class="user-img">
		<?php 
		// use thumb path from helper
		$profileImgPathThumb = (($this->Session->read("Auth.User.Userdetail.image") && file_exists(WWW_ROOT.$this->Session->read("Auth.User.Userdetail.image")))?$this->Session->read("Auth.User.Userdetail.image"): "/img/no-img.png");
		$profileImgThumb = $this->Common->getImageName($profileImgPathThumb, ThumbImageProfilePrefix);

		 echo $this->Html->image($profileImgThumb,array("alt"=>$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"),"width"=>"34px","height"=>"34px"));
		 ?>
		
		</span> 
		<span class="txt"><?php echo ucwords($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")); ?></span>
		<div class="account_btn1" style="display:none;">
		<div class="top-arrow"></div>
		<div class="user-drop-img">
			
			<?php 
			// use thumb path from helper
			$profileImgPathThumb1 = (($this->Session->read("Auth.User.Userdetail.image") && file_exists(WWW_ROOT.$this->Session->read("Auth.User.Userdetail.image")))?$this->Session->read("Auth.User.Userdetail.image"): "/img/no-img.png");
			$profileImgThumb1 = $this->Common->getImageName($profileImgPathThumb1, SmallImageProfilePrefix);
			echo $this->Html->image($profileImgThumb1,array("alt"=>$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"),"width"=>"90px","height"=>"90px"));
			
			?>
		
		</div>
		<div class="user-info"><?php echo ucwords($this->Session->read("Auth.User.Userdetail.designation"));?> <?php echo ucwords($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")); ?><br />
			<span><?php echo $this->Session->read("Auth.User.Userdetail.heading");?></span>
			<br />
			<?php
				echo $this->Html->link("View Profile",array("controller"=>"profile","action"=>$this->Session->read("Auth.User.Userdetail.user_id"),$this->Common->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))),array("title"=>"View Profile"));
				?>
			<span class="edit-icon">
				<?php
				echo $this->Html->link(
					$this->Html->image("/img/edit-icon.png", array("alt" => "Edit Profile","title"=>"Edit Profile" ,"width"=>"18px","height"=>"18px")),
					"/editprofile",
					array('escape' => false)
				);
				?>
				
			</span> 
			<?php /*
			<span class="setting-icon">
				<?php
				echo $this->Html->link(
					$this->Html->image("/img/setting-icon.png", array("alt" => "Profile Settings","title"=>"Profile Settings","width"=>"18px","height"=>"20px")),
					"/account",
					array('escape' => false)
				);
				?>
			</span> */ ?>
		</div>
		<div class="bdr-top">
			<?php echo $this->Html->link("My Courses",array("controller"=>"/mycourses")); ?><br />
			<?php echo $this->Html->link("Messages",array("controller"=>"/inbox")); ?><br />
			<?php //echo $this->Html->link("My Wishlist",array("controller"=>"/mywishlist")); ?><br />
			</div>
			<div class="bdr-top">
			
			
			<?php 
				if (!$this->Session->read("FB.Me.id")) {
					echo '<a href="'.$this->Html->url("/users/logout").'" title="Log Out" ><img src="'.$this->webroot.'img/logout-icon.png" alt="" width="16" height="15" >Log Out</a>';
				} else { 
					echo $this->Facebook->logout(array('label' => 'Logout', 'redirect' => array("controller"=>"users","action"=>'logout'))); 
				}  
			 ?>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="login-reg">
		<a href="<?php echo $this->Html->url("/signup"); ?>" id="signup" class="btn2 login" >Signup</a>/<a href="<?php echo $this->Html->url("/login/".$this->params->url); ?>" id="signin" class="btn2 login">Login</a>
	</div>
<?php } ?>
</div>

<div id= "top_bar" >
	<?php echo $this->Form->create("Course",array("controller"=>"courses","action"=>"search")); ?>
<div class="search-box"><?php echo $this->Form->input("titles",array("type"=>"text","placeholder"=>"What Technology do you want to learn?","label"=>false,"div"=>false)); ?><span  class="go-btn"><a href="javascript:void(0);" title="GO!" id="searchgo">GO!</a></span></div>
<?php echo $this->Form->end(); ?>
	<nav>
	<a id="pull" href="#">Menu</a>
	
	<ul>
		<?php if(!$this->session->read("Auth.User.id")) { ?>
		<li><a href="<?php echo $this->Html->url("/"); ?>" title="Home">Home</a></li>
		<li><a href="<?php echo $this->Html->url("/view-courses"); ?>" title="Courses">Courses</a></li>
		<li><a href="<?php echo $this->Html->url("/login/mycourses"); ?>" id="mycourse">My Courses</a></li>
		<li><a href="<?php echo $this->Html->url("/login/course-manage/create"); ?>" id="createcourse">Teach Online</a></li>
		<li><a href="<?php echo $this->Html->url("/blog"); ?>" title="Blog">Blog</a></li>
		<?php } else { ?>
		<li><a href="<?php echo $this->Html->url("/"); ?>" title="Home">Home</a></li>
		<li><a href="<?php echo $this->Html->url("/view-courses"); ?>" title="Courses">Courses</a></li>
		<li><a href="<?php echo $this->Html->url("/mycourses"); ?>" title="My Courses">My Courses</a></li>
		<li><a href="<?php echo $this->Html->url("/course-manage/create"); ?>" title="Teach Online">Teach Online</a></li>
		<li><a href="<?php echo $this->Html->url("/blog"); ?>" title="Blog">Blog</a></li>
		<?php } ?>
		</ul>
	</nav>
</div>
</div>
</header>
