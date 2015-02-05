<!-- Grid -->
<?php //pr($courses); ?>
<?php if(isset($courses) && !empty($courses)){ ?>
<div class="view-course-list1">
	<ul>
		<?php foreach($courses as $course){ ?>
		<li>	
			<div class="image">
				<?php 
				// use thumb path from helper
				$courseImgPathThumb1 = ((!empty($course['Course']['coverimage']) && file_exists(WWW_ROOT.$course['Course']['coverimage']))?$course['Course']['coverimage']: "/img/no-img.png");
				$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
				?>
				<a href="<?php echo $this->Html->url("/c/".$course['Course']['id']."/".$this->Common->makeurl($course['Course']['title'])); ?>">
					<?php echo $this->Html->image($courseImgThumb1,array("alt"=>$course['Course']['title'],"width"=>"112px","height"=>"112px"));?>
				</a>
			</div>
			<div class="txt"><h2><a href="<?php echo $this->Html->url("/c/".$course['Course']['id']."/".$this->Common->makeurl($course['Course']['title'])); ?>"><?php echo h($course['Course']['title']);?></a></h2>
				<p><a href="<?php echo $this->Html->url("/c/".$course['Course']['id']."/".$this->Common->makeurl($course['Course']['title'])); ?>"><?php echo $this->Common->removetags(substr($course['Course']['summary'],0,200),array("<br>","<i>","b")); echo (strlen($course['Course']['summary']) > 200?" ...":""); ?></a></p>
				<br/>
				<a href="<?php echo $this->Html->url("/profile/".$course['Userdetail']['user_id']."/".$this->Common->makeurl($course['Userdetail']['first_name'].' '.$course['Userdetail']['last_name'])); ?>"><?php echo h(ucwords($course['Userdetail']['first_name'].' '.$course['Userdetail']['last_name']));?></a>
				<span class="rating_star">
					<?php echo $this->element("ratingstars",array("rating"=>$course['Course']['avgrating'])); ?>
				</span>
				<span class="users">
					<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $course['Course']['students']; ?>
				</span>
				<span class="pric"><?php echo h(empty($course['Course']['price'])?"Free":"$".$course['Course']['price']); ?></span>
			</div> 
		</li>
		<?php } ?>
	</ul>
</div>	
<?php } else{
	?>
	<div id="flashMessage" class="noresult">
	<?php
		echo "No Results Found!";
	?>
	</div>
	<?php
} 
?>
