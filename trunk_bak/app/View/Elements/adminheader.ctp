<?php $admin = $this->Session->read('admin'); 
?>
<a href="<?php echo $this->Html->url('/admin/dashboard');?>"><h1><?php echo TITLE_EXT; ?></h1></a>
<div class="co-head">
	<?php if(isset($admin) && !empty($admin)){ 
		//die("hello");
		?>
	<h2 class="user-name">Hi! <?php echo $admin['Admin']['username']; ?>&nbsp;|&nbsp;Last Login <?php echo $admin['Admin']['lastlogin']; ?>&nbsp;|&nbsp;<?php echo $this->Html->link("Logout","/admins/logout"); ?></h2>
	
	<div class="clear"></div>
	<?php //echo $this->element('admin_add_new');?>
	<?php } else {
		//die("here");
		
		}?>
</div>


