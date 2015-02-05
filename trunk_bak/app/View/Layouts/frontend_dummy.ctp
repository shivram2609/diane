<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo $this->Facebook->html(); ?>
<?php echo $this->Html->charset(); ?>
<head>
	<title>
		<?php echo $title_for_layout; ?>
		<?php if ($this->params['controller'] != 'pages') { ?>
		<?php echo(TITLE_EXT); ?>
		<?php } ?>
	</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>
<?php echo $this->Html->script(array('jquery.1.8.2')); ?>
<?php echo $this->Html->css(array("style_old"),NULL,array("media"=>"screen")); ?>
<!--[if IE 8]>  
<link rel="stylesheet" href="ie8.css">  
<![endif]--> 
<script type="text/javascript">
		var BASE_URL = "<?php echo SITE_LINK; ?>";
</script>
</head>
<body>
<?php if($this->params['controller'] == 'users' && in_array($this->params['action'],array("login","signup"))) { ?>
<?php } else { ?>
<?php echo $this->element("header_old"); ?>
<?php } ?>
	<div class="wrapper">
		<?php echo $content_for_layout; ?>
	</div>
	<?php if($this->params['controller'] == 'pages') { /*echo $this->element("pagesection"); */ } ?>
	<?php if($this->params['controller'] == 'users' && in_array($this->params['action'],array("login","signup"))) { ?>
		<?php echo $this->element("popupfooter"); ?>
	<?php } else { ?>
		<?php echo $this->element("frontfooter_old"); ?>
	<?php } ?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
