<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'',"buttontitle"=>'Add State',"listflag"=>false)); ?>
<div class="index">
<h2>Dashboard</h2>
<!-- dashboards left -->
<div class="dashboard-statics">
	<h3 class="hndle">Statistics</h3>
	<div class="inside">
		<div class="table_content">
			<p class="inside-sub">Updates</p>
			<table>
				
				
			</table>
		</div>
		
		<div class="table_content right">
			<p class="inside-sub">News</p>
			<table>
				
			</table>
			</table>
		</div>
	<div class="clear"></div>	
	</div>
	

</div>
<!-- end dashboards left -->

<!-- dashboards right -->
<div class="dashboard-notification">
	<h3 class="hndle">Settings</h3>
	<div class="inside">
		<h4>Account</h4>
		<p class="content"><?php echo $this->Html->link('Change Password', array('controller' => 'admin', 'action' => 'changepassword')); ?></p>
	<div class="clear"></div>	
	</div>
</div>

<!-- end dashboards right -->
</div>
