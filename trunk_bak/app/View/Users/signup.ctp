<style>
#wrapper{min-width:0px;min-height:0px;}
div.login-box{left: 0;right: 0;top: 25%;width: 540px;}
div#cboxClose{right: 11px;top: 10px; background-image: url("../img/close-icon.png");}
</style>
<div class="login-box">
 <div class="box-shadow">
 <h3>Create an account </h3>
 <?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('User',array("enctype"=>"multipart/form-data")); ?>
	<?php echo $this->Form->input('Userdetail.first_name',array("maxlength"=>"50",'class'=>"left",'label'=>false,'div'=>false,'placeholder'=>'Name')); ?>
	<?php echo $this->Form->input('username',array("maxlength"=>"150",'class'=>"left",'label'=>false,'div'=>false,'placeholder'=>'Email')); ?>
	<?php echo $this->Form->input('password',array("maxlength"=>"15","type"=>"password",'class'=>"left ",'label'=>false,'div'=>false,'placeholder'=>'Password')); ?>	
	<div class="clear-fix"></div>
	
	<?php echo $this->Form->submit(__('Signup',true), array('class'=>'signin-btn')); ?>
	<p class="login-txt">Already a user? <a href="<?php echo $this->Html->url("/login"); ?>" title="Log in">Login</a></p>
	</div>
	<div class="signin-facebook">
		<?php echo $this->Facebook->login(array('perms' => 'email','show-faces'=>false,'img'=>"signin-with-facebook.png",'redirect'=>SITE_LINK."login")); ?>
		<span class="or"><span>Or</span></span>
		<a href="javascript:void(0);" onclick="window.open('<?php echo SITE_LINK."login_with_twitter" ?>','mywindow','menubar=0,resizable=0,width=550,height=550')" class="zocial twitter"><?php echo $this->Html->image("/img/singin-with-twitter.png",array("alt"=>"","width"=>"192","height"=>"33")); ?></a> 
	</div>
	<?php echo $this->Form->end(); ?>
 </div>
