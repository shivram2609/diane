<?php if($this->Session->read("Auth.User.id")) { ?>
<div class="profile_section">
	<ul class="top_left_navigation">
		<li>
			<?php if($this->Session->read("Auth.User.type") == 'Business') { ?>
				<a href="<?php echo $this->Html->url("/addcampaign"); ?>" class="<?php echo ($this->params['controller'] == 'campaigns')?'active':'' ?>">Add Campaign</a>
			<?php } else { ?>
				<a href="<?php echo $this->Html->url("/campaigns"); ?>" class="<?php echo ($this->params['controller'] == 'campaigns')?'active':'' ?>">Search Campaign</a>
			<?php } ?>
		</li>
		<li><a href="<?php echo $this->Html->url("/inbox"); ?>" class="<?php echo ($this->params['controller'] == 'messages')?'active':'' ?>" >Messages</a></li>
		<li><a href="<?php echo $this->Html->url("/transactions"); ?>" class="<?php echo ($this->params['controller'] == 'orders')?'active':'' ?>">View Transactions</a></li>
	</ul>
</div>
<div style="clear: both;"></div>
<?php } ?>
