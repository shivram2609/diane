<div class="users view">
<h2><?php  echo __('Choose Profile Type'); ?></h2>
<?php echo $this->Form->create("User"); ?>
	<dl>
		<dt><?php echo __('Select profile type'); ?></dt>
		<dd>
			<?php echo $this->Form->input("type",array("options"=>array(""=>"Select Type","Business"=>"Business","Publisher"=>"Publisher"),"label"=>false,"div"=>false));; ?>
			&nbsp;
		</dd>
	</dl>	
	<dl>
		<dt>&nbsp;</dt>
		<dd>
			<?php echo $this->Form->submit("Submit"); ?>
			&nbsp;
		</dd>
	</dl>	
<?php echo $this->Form->end(); ?>
</div>
