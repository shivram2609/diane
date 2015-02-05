<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft');?>
	<section class="right-panel">
		<div class="account-cont">
			<h1>Delete Account</h1><br>
			<span>&nbsp;</span>
			<div class="row">
				<div class="category-box-text">
							<h2>Delete Account</h2>
						</div>
						<div class="delt">
					<p class="txt-center">&nbsp;</p>		
					<?php echo $this->Form->create('Userdetail'); ?>
					<?php echo $this->Form->hidden('remove',array('removeAccount'=>'yes'));?>
					<?php echo $this->Form->Submit("Delete",array('label'=>false,'div'=>false,'class'=>'red-btn','onclick'=>'if(confirm("Are you sure you want to delete your account?")) { return true; } else { return false;}')); ?>				
				</div>
			</div>
		</div>
	</section>	
</div>
