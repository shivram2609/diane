<div class="txt-center logo"><img src="<?php $this->webroot ?>img/logo.png"/></div>
<?php echo $this->Session->flash(); ?>
<div class="login_outer">
	
<?php
    echo $this->Form->create('Admin');
    echo $this->Form->input("username",array("div"=>false,"type"=>"text","label"=>'Username'));
    echo $this->Form->input('password',array("label"=>'Password',"type"=>'password',"div"=>false));
    echo $this->Form->input('remember_me', array('type' => 'checkbox','checked'=>false, 'label'=>array('text'=>'Remember me')));
    echo $this->Form->end('Login');
?>

<div class="login-as"><?php echo $this->Html->link("Forgot Password?",'/admins/forgotpassword'); ?></div>

<div class="clear"></div>
</div>
