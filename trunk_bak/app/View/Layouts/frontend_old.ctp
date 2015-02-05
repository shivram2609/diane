<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo $this->Facebook->html(); ?>
<head>
<?php echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon')); ?>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
		<?php if ($this->params['controller'] != 'pages') { ?>
		<?php echo(TITLE_EXT); ?>
		<?php } ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('frontend','extra'));
		echo $scripts_for_layout;
	?>
	<script type="text/javascript">
		var BASE_URL = "<?php echo SITE_LINK; ?>";
	</script>
</head>
<body>
		<?php 
		
		if($this->params['action'] != 'forgotpassword' && $this->params['action'] != 'login') { ?>
			<div id="header">
				<?php echo $this->element("frontheader"); ?>
			</div>
		<?php } ?>
		<div id="container">
			<div id="content">
				<?php 
				
				// -- to set the design on login page
				if($this->params['action']== 'forgotpassword' || $this->params['action'] == 'login') 
					$ContentId = ''; 
				  else
					$ContentId = 'content-for-layout'; 
				?>
				
				<div id="<?=$ContentId;?>">
				<?php echo $content_for_layout; ?>
				</div>
				<?php if ($this->Session->read("FB.Me.id") || $this->params['action'] == 'login' ) { ?>
				<?php echo $this->Facebook->init(); ?> 
				<?php } ?>
			</div>
		</div>
		<div id="footer">
			<?php echo $this->Html->script(array('jquery.1.8.2','jquery.validate','validationmessages','functionality')); ?>
			<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if($this->params['controller'] == "campaigns" && $this->params['action'] == "add") { ?>
	<?php echo $this->Html->script("jquery.ui"); ?>
	<?php echo $this->Html->script("jquery.colorbox"); ?>
	<?php echo $this->Html->css("jquery.ui"); ?>
	<?php echo $this->Html->css("colorbox"); ?>
	<script type="text/javascript" charset="utf-8"> 
	$(document).ready(function(){
		$(function() {
			$("#CampaignDeadline").datepicker().on("show", function() {
				$("#CampaignDeadline").val("01.05.2012").datepicker('update');
			});
		});
	});
	</script>
	<?php echo $this->Colorbox->openinlinepop("inline","70%","75%"); ?>
	<?php } ?>
	<?php
	/* end of code to include colorbox and jquery.ui for campaign add page only */
	?>
	<?php
	/* code to include colorbox hiring confirmation popup */
	?>
	<?php if(($this->params['controller'] == "campaigns" && $this->params['action'] == "hire") || ($this->params['controller'] == "applications" && in_array($this->params['action'],array("index","view"))) ) { ?>
		<?php echo $this->Html->script("jquery.colorbox"); ?>
		<?php echo $this->Html->css("colorbox"); ?>
		<?php echo $this->Colorbox->openinlinepop("inline","40%","45%"); ?>
	<?php } ?>
	<?php
	/* end of code to include colorbox hiring confirmation popup */
	?>
		</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
