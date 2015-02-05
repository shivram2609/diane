<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft');?>
	<section class="right-panel">
		<div class="account-cont">
			<h1>
				Paypal Account<br>
				<span>&nbsp;</span>
			</h1>
			<?php echo $this->Form->create('User',array("enctype"=>"multipart/form-data")); ?>
			<div class="row">
				<div class="category-box-text">
				<h2>PayPal Email</h2>
				</div><br>
				<div class="delt">
					<?php echo $this->Form->input('Userdetail.paypalaccount',array("placeholder"=>"PayPal Email", "div"=>false,"label"=>false,"type"=>"text", "class"=>"access g_p")); ?>
					
				</div>
			</div>
			
		</div>
		<p class="txt-center"><?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn l_b_p')); ?></p>
	</section>		
</div>
