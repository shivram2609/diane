<style>
#flashMessage{ margin:auto; width:32%; margin-top:20px; float:none!important; background:#F2FFEA!important; border: 1px solid #49B727!important;}
</style>
<div class="txt-center logo">

<?php echo $this->Html->link($this->Html->image("/img/thin,fit & helathy logo.png"),"/admin",array('escape' => false)); ?>
</div>
<?php echo $this->Session->flash(); ?>
<div class="login_outer">
<?php
echo $this->Form->create("Admin");
echo $this->Form->input("Admin.email",array("type"=>"text","div"=>false,"label"=>'Email'));
echo $this->Form->end("Submit");
?>
<div class="login-as"><?php echo $this->Html->link("Login",'/admin'); ?></div>
<div class="clear"></div>
</div>
