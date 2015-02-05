<div class="container">
<div class="clear-fix"><p>&nbsp;</p><p>&nbsp;</p></div>
	<aside class="left-container">
	<div class="left-bar-2">
		<?php 
		
		/* <ul>
			<li class="selected"><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="Featured">Featured</a></li>
			<li><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="Curriculum">Curriculum</a></li>
			<li><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="New &amp; Noteworthy">New &amp; Noteworthy</a></li>
			<li><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="Top Paid">Top Paid</a></li>
			<li><a href="<?php echo $this->Html->url("/view-courses/all"); ?>" title="On Sale">On Sale</a></li>
		</ul><?php */ ?>
		<h2><?php echo $header; ?></h2>
		<ul>
			<li class="extracat">Additional Categories</li>
			<?php if (strtolower($header) != 'all') { ?>
				<li class="<?php echo (isset($catid) && $catid == 'all')?'selected':''; ?>"><a href="<?php echo $this->Html->url("/view-courses"); ?>" title="All">All</a></li>
			<?php } ?>
			<?php foreach($categories as $key=>$val) { ?>
				<?php if($val != $header) { ?>
					<li class="<?php echo (isset($catid) && $catid == $key)?'selected':''; ?>" ><a href="<?php echo $this->Html->url("/view-courses/".$this->Common->makeurl($val)."/".$key); ?>" title="<?php echo $val ?>"><?php echo $val ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
		<?php /* if(!$this->Session->read("Auth.User.id")) { ?>
			<a href="<?php echo $this->Html->url("/login"); ?>" class="wishlist"><img src="<?php echo $this->webroot; ?>img/create-course-banner.jpg" alt="" width="189" height="172" /></a>
		<?php } else { ?>
			<a href="<?php echo $this->Html->url("/course-manage/create"); ?>" class="wishlist"><img src="<?php echo $this->webroot; ?>img/create-course-banner.jpg" alt="" width="189" height="172" /></a>
		<?php } */?>
		</div>
	</aside>
	<section class="right-panel-2">
		<?php echo $this->Session->flash(); ?>
		<br/>
		<h1><?php echo $header; ?> Courses<br>
			<span>&nbsp;</span>
		</h1>				
		<div class="view-course-btns">
		<?php echo $this->Form->create("Course", array('id'=>'CourseSearchFormFilter')); ?>
		<ul>
		<li>Language<br>
			<div class="price">
				<?php echo $this->Form->input("language_id",array("label"=>false,"options"=>$languages,"value"=>$this->Session->read("searchcond.Course.language_id"),"empty"=>"All","div"=>false,"class"=>"searchcourse")); ?>
			</div>
		</li>
		<li>Sort<br>
			<div class="price">
				<?php echo $this->Form->input("sort_option",array("label"=>false,"options"=>array("popular"=>"Popularity", "newest"=>"Newest","reviews"=>"Reviews"),"value"=>$this->Session->read("searchcond.Course.sort_option"),"empty"=>"All","div"=>false,"class"=>"searchcourse")); ?>
			</div>
		</li>
		<li>Price<br>
			<div class="price">
			<?php echo $this->Form->input("pricetype",array("label"=>false,"options"=>array("Paid"=>"Paid","Free"=>"Free"),"value"=>$this->Session->read("searchcond.Course.pricetype"),"empty"=>"All","div"=>false,"class"=>"searchcourse")); ?>
			</div>
		</li>
		<?php /*<li>View<br/>
		
		<?php 
		if(isset($this->data['Course']['viewPage'])):
			$view = $this->data['Course']['viewPage'];
		else:
			$view = 'List';
		endif;
		echo $this->Form->hidden("viewPage", array("value"=>$view));?>
		  <span class="viewPage">
			  <?php if($view == 'List') { ?>
				<a href="#" id="Grid"><?php echo $this->Html->image("btn-thum1.png", array("style"=>"cursor:pointer"));?></a>
				<a href="#" id="List"><?php echo $this->Html->image("btn-grid1.png", array("style"=>"cursor:pointer"));?></a>
			  <?php } else { ?>
				<a href="#" id="Grid"><?php echo $this->Html->image("btn-thum.png", array("style"=>"cursor:pointer"));?></a>
				<a href="#" id="List"><?php echo $this->Html->image("btn-grid.png", array("style"=>"cursor:pointer"));?></a>
			  <?php } ?>
		  </span>  
		</li>
		* */ ?>
		</ul>
		<?php echo $this->Form->end(); ?>

		 </div>
		<div id="changedata">
			<?php echo $this->element('search'); ?>
		</div>
	 </section>
	 <?php if(count($courses) > 0 || isset($this->params['named']['page'])) { ?>
	 	<div class="pagination-box">
			<div class="paging">
				<span class="prev-pagination-lnk"><?php echo $this->Paginator->prev('< ' . __('Prev  '), array(), null, array('class' => 'prev disabled')); ?></span>
				<?php if($this->Paginator->hasPrev()) { ?>
					<span class="prev-pagination-lnk"><?php echo $this->Paginator->first('First', array(), null, array('class' => 'prev disabled')); ?></span>
				<?php } ?>
				<span class="pge-no"><?php  echo $this->Paginator->numbers(array('separator' => '</span><span class="pge-no">'));?> <?php // echo $this->Paginator->numbers(array('first' => 2, 'last' => 2)); ?></span>
				<?php if($this->Paginator->hasNext()) { ?>
					<span class="prev-pagination-lnk"><?php echo $this->Paginator->last('Last', array(), null, array('class' => 'prev disabled')); ?></span>
				<?php } ?>
				<span class="next-pagination-lnk"><?php echo $this->Paginator->next(__('Next >'), array(), null, array('class' => 'next disabled'));?></span>
			</div>
		</div>
	<?php } ?>
	
</div>		
