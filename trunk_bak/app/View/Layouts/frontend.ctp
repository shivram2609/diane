<!DOCTYPE HTML>
<?php echo $this->Facebook->html(); ?>
<head>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<?php echo $this->Html->charset(); ?>
	<?php echo $this->Html->meta('icon'); ?>
	<meta name="title" content="<?php echo SEO_META_TITLE; ?>">
	<meta name="keywords" content="<?php echo SEO_META_KEYWORD; ?>">
	<meta name="description" content="<?php echo SEO_META_DESC; ?>">
	<?php if(isset($privacy) && empty($privacy['Show Profile in Search Engines'])) { ?>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<?php } ?>
	<?php if($this->params['action'] == 'view' && $this->params['controller'] == 'courses') { 
			$courseImgPathThumb1 = ((!empty($coursedetail['Course']['coverimage']) && (file_exists(WWW_ROOT.$coursedetail['Course']['coverimage'])))?$coursedetail['Course']['coverimage']: "img/cover1.png");
		?>
		<meta property="og:image" content="<?php echo SITE_LINK.$courseImgPathThumb1; ?>"/>
		<meta property="og:image:width" content="200" />
		<meta property="og:image:height" content="200" />
		<?php if (!empty($coursedetail['Course']['summary'])) { ?>
			<meta property="og:description" content="<?php echo substr(strip_tags($coursedetail['Course']['summary']),0,200); ?>"/>
		<?php } else { ?>
			<meta property="og:description" content="<?php echo strip_tags($coursedetail['Course']['title']); ?>"/>
		<?php } ?>
	<?php } ?>
	
	<?php if($this->params['action'] == 'index' && $this->params['controller'] == 'pages') { ?>
		<meta property="og:image" content="<?php echo SITE_LINK."img/banner_fb.jpg"; ?>"/>
		<meta property="og:image:width" content="300" />
		<meta property="og:image:height" content="300" />
		<meta property="og:description" content="The 1337 Institute of Technology was pioneered by a creative maverick IT professor who believes in the mission of bringing accessible, affordable, and engaging, technological education to the world. There are so many great minds out there that need a platform to teach and share their knowledge with everyone, empowering students to advance their education and careers."/>
	<?php } ?>
	
	
	<?php if($this->params['action'] == 'viewprofile' && $this->params['controller'] == 'users') { 
			$profileImgPathThumb2 = ((!empty($user['Userdetail']['image']) && file_exists(WWW_ROOT.$user['Userdetail']['image']))?$user['Userdetail']['image']: "img/profile1.png");
	?>
		<meta property="og:image" content="<?php echo SITE_LINK.$profileImgPathThumb2; ?>"/>
		<meta property="og:image:width" content="200" />
		<meta property="og:image:height" content="200" />
		<?php if(!empty($user['Userdetail']['biography'])) { ?>
			<meta property="og:description" content="<?php echo substr(strip_tags($user['Userdetail']['biography']),0,200); ?>"/>
		<?php } else { ?>
			<meta property="og:description" content="<?php echo h($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?>"/>
		<?php } ?>
	<?php } ?>
	<meta charset=UTF-8>
	<!--<meta name="description" content="Instute of Technology">-->
	<?php //pr($this->params);?>
	<?php if ($this->params['controller'] == 'pages' && $this->params['action'] == 'staticpages') { 
		echo $this->element('pagemeta');
	} ?>
	<title>
		<?php echo $title_for_layout; ?>
		<?php if ($this->params['controller'] == 'pages' && $this->params['action'] == 'index') { ?>
			<?php echo ""; ?>
		<?php } else { ?>
			<?php echo(TITLE_EXT); ?>
		<?php } ?>
	</title>
	<?php echo $this->Html->script(array('jquery.1.8.2','jquery.form','placeholder','html5')); ?>
	<?php if(($this->params['controller'] == 'courses') && ($this->params['action'] == 'view')) { ?>
		<?php echo $this->Html->css(array("style","flexslider","domtab"),NULL,array("media"=>"screen")); ?>
	<?php } else{ ?>
		<?php echo $this->Html->css(array("jquery-ui","ie8","style","flexslider","uniform.default","domtab","reset"),NULL,array("media"=>"screen")); ?>
	<?php } ?>
<!--[if IE 9]>  
<?php echo $this->Html->css(array("ie8"),NULL,array("media"=>"screen")); ?>  
<![endif]--> 
<!--[if IE 9]>  
<?php //echo $this->Html->script(array('html5')); ?>
<![endif]--> 
<script type="text/javascript">
		var SITE_LINK = "<?php echo SITE_LINK; ?>";
		var BASE_URL = "<?php echo SITE_LINK; ?>";
		var DEFAULT_LINK = "<?php echo $this->webroot; ?>";
</script>

</head>
<body>
	<div id="wrapper">
		<?php if(isset($mobile) && $this->Session->read("mobile") &&  $this->Session->read("mobile") == 1) { ?>
			<!--<div class="mobile">Working on new version to be compatible with mobile devices.</div>-->
			<script>
				alert("Current site of 1337 Institute of Technology is not Fully compatible with mobile devices. A few of the features might not work properly on the Mobile Devices.\n We are working on a newer version to be compatible with mobile devices.");
			</script>
		<?php } ?>
		<?php if(($this->params['controller'] == 'users' && in_array($this->params['action'],array("login","signup","forgotpassword"))) || ($this->params['controller'] == 'courses' && in_array($this->params['action'],array("viewuserquestion")))) { ?>
		<?php } else { ?>
		<?php echo $this->element("header"); ?>
		<?php } ?>
		<?php echo $content_for_layout; ?>
		<?php if($this->params['controller'] == 'pages') { /*echo $this->element("pagesection"); */ } ?>
	</div>
	<?php if($this->params['controller'] == 'users' && in_array($this->params['action'],array("login","signup","forgotpassword")) || ($this->params['controller'] == 'courses' && in_array($this->params['action'],array("viewuserquestion")))) {  ?>
		<?php echo $this->element("popupfooter"); ?>
	<?php } else { ?>
		<?php echo $this->element("frontfooter"); ?>
	<?php } ?>
				
	<script type="text/javascript" src="<?php echo $this->webroot;?>js/domtab.js"></script>
	<script type="text/javascript">
		document.write('<style type="text/css">');    
		document.write('div.domtab div{display:none;}<');
		document.write('/s'+'tyle>');    
    </script>
    
	<?php echo $this->element('sql_dump'); ?>
	
</body>
</html>
