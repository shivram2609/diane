<div class="footer">
	<div class="wrapper">
		
	</div>
</div>
<?php echo $this->Html->script(array('jquery.1.8.2','jquery.validate','validationmessages','jquery.form')); ?>
<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'editcurriculum') { ?>
<?php echo $this->Html->script('ckeditor/ckeditor');  ?>
<?php echo $this->Fck->loadlecturecontent('addtext'); ?>
<?php } ?>
<?php echo $this->Html->script("functionality"); ?>
<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if(!$this->Session->read("Auth.User.id") ) { ?>
	<?php echo $this->Html->script("jquery.colorbox"); ?>
	<?php echo $this->Html->css("colorbox"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("signin","70%","60%"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("signup","70%","60%"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("mycourse","600","540px"); ?>
<?php } ?>
<?php
/* end of code to include colorbox and jquery.ui for campaign add page only */
?>
<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if($this->params['controller'] == "users" && ($this->params['action'] == "confirmregisteration") ) { ?>
	<?php $url = SITE_LINK."login"; ?>
	<?php echo $this->Colorbox->openexternalpopup ("signup","70%","60%"); ?>
<?php } ?>
<?php
/* end of code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if ($this->Session->read("FB.Me.id") || $this->params['action'] == 'login' ) { ?>
<?php echo $this->Facebook->init(); ?> 
<?php } ?>
