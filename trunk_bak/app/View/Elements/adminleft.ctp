<style> #accordion ul { display: block !important;} </style>
<script type="text/javascript">
	$(document).ready(function() {
		$(".unlinkit").click(function(e){
			alert("The page is under Construction!");
			e.preventDefault();
		});
	});
</script>
<div id="adminMenu" class="ddsmoothmenu actions">
<a class="side-bar" onclick="hidepanel();" id="btn" href="javascript:void(0);" title="Click to hide panel" >Click to hide panel</a>
<ul>
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Dashboard</a></li>
	</ul>
	<ul class="sublist-menu <?php echo ((($this->params['controller']=='admins' && ($this->params['action'] =='dashboard' ||  $this->params['action'] =='newsletter' ||  $this->params['action'] =='changepassword' ||  $this->params['action'] =='configurations' ||  $this->params['action'] =='editprofile')) || $this->params['controller']=='orders' || $this->params['controller']=='backupdbs')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link("Change Password","/admin/changepassword"); ?></li>
		<li><?php echo $this->Html->link("Database Backups","/admin/backupdbs"); ?></li>
		<li><?php echo $this->Html->link("Configuration","/admin/configurations"); ?></li>
		<li><?php echo $this->Html->link("Newsletter","/admin/newsletter"); ?></li>
		<li><?php echo $this->Html->link("Transactions","/admin/orders"); ?></li>
	</ul>
	<?php $admin = $this->Session->read("admin"); 
	?>
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Users</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='users')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Users', true), '/admin/users/index');?></li>
	</ul>	
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Categories</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='categories')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Categories', true), '/admin/categories/index');?></li>
		<li><?php echo $this->Html->link(__('Add Category', true), '/admin/categories/add');?></li>
	</ul>	
	
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Courses</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='courses')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Courses', true), '/admin/courses/index');?></li>
	</ul>
	
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Languages</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='languages')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Languages', true), '/admin/languages/index');?></li>
		<li><?php echo $this->Html->link(__('Add Language', true), '/admin/languages/add');?></li>
	</ul>	
	
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Email Templates</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='cmsemails')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Email Templates', true), '/admin/cmsemails/index');?></li>
	</ul>	
	<ul class="admintoggel">
		<li><a href="javascript:void(0);" class="Admins">Static Pages</a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['controller']=='cmspages')?'hide1':'hide'); ?>">
		<li><?php echo $this->Html->link(__('Static Pages', true), '/admin/cmspages/index');?></li>
	</ul>	
	
	
	<ul class="admintoggel"><?php //pr($this->params);     ?>
		<li><a href="<?php echo $this->Html->url('/admin/blog'); ?>" <?php if ($this->params['controller'] == 'blog_posts' && $this->params['action'] == 'admin_index') { ?> class="active" <?php } ?> >Blog </a></li>
	</ul>
	<ul class="sublist-menu <?php echo (($this->params['plugin'] == 'blog') ? '' : 'hide'); ?>"><li><a href="<?php echo $this->Html->url('/admin/blog_post_categories'); ?>" <?php if ($this->params['controller'] == 'admin' && $this->params['action'] == 'blog_post_categories') { ?> class="active" <?php } ?> >Blog Categories </a></li>
		<li><a href="<?php echo $this->Html->url('/admin/blog/blog_settings'); ?>" <?php if ($this->params['controller'] == 'blog' && $this->params['action'] == 'blog_settings') { ?> class="active" <?php } ?> >Blog Settings </a></li>
		<li><a href="<?php echo $this->Html->url('/admin/blog/blog_post_tags'); ?>" <?php if ($this->params['controller'] == 'blog' && $this->params['action'] == 'blog_post_tags') { ?> class="active" <?php } ?> >Blog Post Tags </a></li>
	</ul>
	
	
<br style="clear: left" />
</ul>
</div>
	
