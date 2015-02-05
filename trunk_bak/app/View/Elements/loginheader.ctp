<div class="header">
	<div class="wrapper">

		<a href="<?php echo SITE_LINK; ?>" class="logo header-logo" title="Hypefly"></a>
		<ul class="top_links">
			<li><a href="#">Industries</a></li>
			<li><?php echo $this->Html->link("Browse Listing",array("controller"=>"/campaigns"),array("title"=>"Browse Listing")); ?></a></li>
		</ul>
		<div class="right_header">
			<?php if($this->Session->read("Auth.User.type") == 'Business') { ?>
			<a href="<?php echo ($this->Session->read("Auth.User.type") == 'Business'?$this->Html->url("/addcampaign"):"Javascript:void(0);"); ?>" class="post_campaign_btn post-campaign "></a>
			<?php } ?>
			<div class="acc_drpdwn my-account ">
				<div class="account_btn1" style="display:none;">
					<?php
					echo $this->Html->link("Profile",array("controller"=>"profile","action"=>$this->Session->read("Auth.User.Userdetail.user_id"),$this->Common->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))));
					if ($this->Session->read("Auth.User.type") == 'Business') {
						//echo $this->Html->link("Add Campaign",array("controller"=>"addcampaign"));
						echo $this->Html->link("Active Campaigns",array("controller"=>"mycampaigns"));
						echo $this->Html->link("Expired Campaigns",array("controller"=>"mycampaigns","action"=>"p"));
						echo $this->Html->link("Campaign Requests",array("controller"=>"campaignrequests"));
					} else {
						echo $this->Html->link("Sent Applications",array("controller"=>"sentapplications"));
					}
					echo $this->Html->link("Messages",array("controller"=>"/inbox"));
					echo $this->Html->link("Open Contracts",array("controller"=>"/opencontracts"));
				    echo $this->Html->link("Complete Contract",array("controller"=>"/closecontracts"));
					?>
					<a href="<?php echo $this->Html->url("/editprofile"); ?>" >Account Settings</a>
					<?php 
						if (!$this->Session->read("FB.Me.id")) {
							echo $this->Html->link("Change Password","/changepassword"); 
						 }
					 ?>
					<?php 
						if (!$this->Session->read("FB.Me.id")) {
							echo $this->Html->link("Logout","/users/logout");
						} else { 
							echo $this->Facebook->logout(array('label' => 'Logout', 'redirect' => array("controller"=>"users","action"=>'logout'))); 
						}  
					 ?>
				</div>
			</div>
			
		</div>
	</div>
</div>
