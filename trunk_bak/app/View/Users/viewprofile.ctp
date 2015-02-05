<div class="container">
	<?php echo $this->Session->flash(); $flag = false; if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $user['User']['id']) { $flag = true;  } ?>
	<?php if($flag  || empty($privacy['make profile private'])) { ?>
		<div class="profile-box">
			<!-- User Image -->
			<div class="user-pro-img">
				<?php 
				// use thumb path from helper
				$profileImgPathThumb2 = ((!empty($user['Userdetail']['image']) && file_exists(WWW_ROOT.$user['Userdetail']['image']))?$user['Userdetail']['image']: "/img/no-img.png");
				$profileImgThumb2 = $this->Common->getImageName($profileImgPathThumb2, MediumSmallProfileImagePrefix);
				echo $this->Html->image($profileImgThumb2,array("alt"=>$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"),"width"=>"108px","height"=>"108px"));
				?>
			</div>
			<!-- User Image -->
			<!-- User Detail -->
			<div class="user-pro-txt">
				<h2><?php echo h($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?></h2>
				<span class="abt_cnt viewprofile" id="abt_cnt" style="display:inline;">
				<?php if(!empty($user['Userdetail']['biography'])) { echo substr($this->Common->removetags($user['Userdetail']['biography']),0,499)."</li></ul></ol></p>"; } else { echo ""; } ?></span>
				<span class="abt_cnt viewprofilelarge" id="abt_cnt" style="display:none;">
				<?php if(!empty($user['Userdetail']['biography'])) { echo $this->Common->removetags($user['Userdetail']['biography']); } else { echo ""; } ?></span>
				<!-- Social Icons -->
				<ul class="social_media-sml">
					<li><span class='st_facebook_large fb' displayText='Facebook'></span></li>
					<li><span class='st_twitter_large twitter' displayText='Tweet'></span></li>
					<li><span class='st_linkedin_large linkedin' displayText='LinkedIn'></span></li>
					<li><span class='st_googleplus_large gplus' displayText='Google +'></span></li>
					<li><span class='st_pinterest_large pinterest' displayText='Pinterest'></span></li>
				</ul>
				<!-- Social Icons -->
				<?php if(strlen($user['Userdetail']['biography']) > 500) { ?>
					<div class="more-btn" id="more"><a href="#" title="More">+ More</a></div>
				<?php } ?>
			</div>
		<!-- Following/ Follower Functionality -->
		<div class="profile-box-rt">
			<div class="rt-btns">
				<span class="following"><?php echo(!empty($follower['Follower']['Following'])?$follower['Follower']['Following']:'0');?><br/><?php  echo ($follower['Follower']['Following'] > 1) ?'Followings':'Following' ?></span>
				<span class="followers"><?php echo (!empty($follower['Follower']['Followers'])?$follower['Follower']['Followers']:'0');?><br/><?php echo ($follower['Follower']['Followers'] >1)?'Followers':'Follower'; ?></span>
			</div>
			<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $user['User']['id']) { ?>
					<span class="profile-edit-btn"><a href="<?php echo $this->Html->url("/editprofile"); ?>" title="Edit Profile">Edit Profile</a></span>
				<?php } elseif(!($this->Session->read("Auth.User.id"))) { ?>
					<span class="profile-edit-btn"><a href="<?php echo $this->Html->url("/login/"); ?>" class="wishlist" >Follow</a></span>
				<?php } elseif(isset($follower) && !empty($follower) && !empty($follower['Follower']['Followed'])) { ?>
					<span class="profile-edit-btn"><a href="<?php echo $this->Html->url("/unfollow/".$user['User']['id']); ?>" title="Follow">Unfollow</a></span>
				<?php } else { ?>
					 <span class="profile-edit-btn"><a href="<?php echo $this->Html->url("/follow/".$user['User']['id']); ?>" title="Follow">Follow</a></span>
				<?php } ?>
		</div>
		<!-- Following/ Follower Functionality -->
	</div>
	<!-- End profile-box -->
		<?php if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $user['User']['id']) { ?>	
			<div class="profile-btns">
				<?php /* <span class="btns"><a href="<?php echo $this->Html->url("/mywishlist"); ?>" title="Wishlist Course">Wishlist (<?php echo $user['Userdetail']['wishlist']; ?>)</a></span>  */ ?>
				<span class="btns"><a href="<?php echo $this->Html->url("/myenrolled"); ?>" title="Enrolled Course">Enrolled (<?php echo $user['Userdetail']['learning']; ?>)</a></span>   
				<span class="btns"><a href="<?php echo $this->Html->url("/mycompleted"); ?>" title="Completed Course">Completed (<?php echo $user['Userdetail']['completed']; ?>)</a></span> 
				<span class="btns"><a href="<?php echo $this->Html->url("/mycourses"); ?>" title="Teaching Course">Teaching (<?php echo $user['Userdetail']['countcourse']; ?>)</a></span>  
			  
			</div>	
		<?php } elseif(!empty($privacy['Show Courses in Profile'])) { ?>
			<div class="profile-btns">
				<?php /*<span class="btns"><a href="<?php echo $this->Html->url("/wishlist/w/".$user['Userdetail']['user_id']); ?>" title="Wishlist">Wishlist (<?php echo $user['Userdetail']['wishlist']; ?>)</a></span>  */ ?>
				<span class="btns"><a href="<?php echo $this->Html->url("/enrolled/l/".$user['Userdetail']['user_id']); ?>" title="Enrolled Course">Enrolled (<?php echo $user['Userdetail']['learning']; ?>)</a></span>   
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="profile-box">
			<div class="user-pro-txt">
				User has made his profile private.
			</div>
		</div>
	<?php } ?>
<?php echo $this->element("latestcourses"); ?>
</div>
