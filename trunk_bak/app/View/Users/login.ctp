<style>
#wrapper{min-width:0px;min-height:0px;}
</style>
 <div class="login-box">
 <div class="box-shadow">
 <h3>Sign into your account </h3>
 <?php echo $this->Form->create('User'); ?>
 <?php echo $this->Session->flash(); ?>
		<?php echo $this->Form->input("username",array("div"=>true,"type"=>"text","label"=>false,"placeholder"=>"Email")); ?>
		<?php echo $this->Form->input('password',array("label"=>'Password',"type"=>'password',"div"=>true,"label"=>false,"placeholder"=>"Password")); ?>
		<div class="clear-fix"></div>
		<div class="keep-me"><?php echo $this->Form->input('remember_me', array('type' => 'checkbox','checked'=>false, 'label'=>'Keep me logged in','div'=>false)); ?></div>
		<div class="forgot-password"><a href="<?php echo $this->Html->url("/forgotpassword"); ?>" title="Forgot  your password?">Forgot your password?</a></div>
		<div class="clear-fix"></div>
		<?php echo $this->Form->submit("Login",array("class"=>"login-btn ","div"=>false,"label"=>false)) ?>
		<p class="sign-up">Don't have an account yet? <a href="<?php echo $this->Html->url("/signup"); ?>" title="Sign in">Signup</a></p>
		</div>
		<div class="signin-facebook">
			<?php echo $this->Facebook->login(array('perms' => 'email','show-faces'=>false,'img'=>"signin-with-facebook.png",'redirect'=>SITE_LINK."login")); ?>
			<span class="or"><span>Or</span></span>
			<a href="javascript:void(0);" onclick="window.open('<?php echo SITE_LINK."login_with_twitter" ?>','mywindow','menubar=0,resizable=0,width=550,height=550')" class="zocial twitter"><?php echo $this->Html->image("/img/singin-with-twitter.png",array("alt"=>"","width"=>"192","height"=>"33")); ?></a> 
		</div>
		
<?php echo $this->Form->end(); ?>
 </div> 

