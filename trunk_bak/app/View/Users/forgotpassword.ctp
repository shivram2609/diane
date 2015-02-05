<style>
#wrapper{min-width:0px;min-height:0px;}

</style>
<script type="text/javascript">
	$(document).ready(function(){
		setInterval('$("#flashMessage").hide();',2000);
	});
</script>
<div class="login-box">
 <div class="box-shadow">
<h3>Forgot your password </h3>
<?php
				echo $this->Form->create("User");
				echo $this->Session->flash();
				echo $this->Form->input("User.username",array("type"=>"text","div"=>'usrnme_eml_bx',"label"=>false,"placeholder"=>"Email","class"=>"chng_pswd_fld"));
			?>
	<p class="txt-center"><?php echo $this->Form->Submit("Reset password",array('label'=>false,'div'=>false,'class'=>'reset-pass')); ?></p>
	
	<div class="clear-fix"></div>
	<?php echo $this->Form->end(); ?>
	</div>
	<div class="back-login">Back to <a href="<?php echo $this->Html->url("/login"); ?>" title="login">Login</a></div>
</div>
