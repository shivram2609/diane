<div class="container">
	<div class="wish-list">
		<h1>Recent Courses</h1>
	<?php //pr($courses);?>
		<div class="listing">
			<ul>
			<?php if(!empty($usersview)) { //pr($usersview); die; 
				foreach ($usersview as $key=>$val) {
				?>
				<li>
					<div class="img">
						<?php 
						// use thumb path from helper
						$courseImgPathThumb1 = ((!empty($val['Course']['coverimage']) && file_exists(WWW_ROOT.$val['Course']['coverimage']) )?$val['Course']['coverimage']: "/img/no-img.png");
						$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, SmallCourseImagePrefix);
						echo $this->Html->image($courseImgThumb1,array("alt"=>$val['Course']['title'],"width"=>"112px","height"=>"112px"));
						
						?>
					</div>
					<div class="txt">
						<span class="right"></span>
						<h2>
							<a href="<?php echo $this->Html->url("/c/".$val['Course']['id'].'/'.$this->Common->makeUrl($val['Course']['title'])); ?>"><?php echo $val['Course']['title']; ?></a>
						</h2>
						<p>
							<a href="<?php echo $this->Html->url('/c'."/".$val['Course']['id']."/".$this->Common->makeUrl($val['Course']['title'])); ?>" title="<?php echo h($val['Course']['title']); ?>"><?php echo $this->Common->removetags(substr($val['Course']['summary'],0,500),array("<br>","<i>","b")); echo (strlen($val['Course']['summary']) > 500?" ...":""); ?>  </a>
						</p>
						<span class="rating_star">
							<?php echo $this->element("ratingstars",array("rating"=>$val['UserViewCourse']['review'])); ?>
						</span>	
						<a href="<?php echo $this->Html->url("/profile/".$val['Course']['user_id']."/".$this->Common->makeurl($val['UserViewCourse']['name'])); ?>"><?php echo ucwords($val['UserViewCourse']['name']); ?></a>
						<span class="users">
							<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $val['UserViewCourse']['students']; ?>
						</span>
						<span class="pric"><?php echo empty($val['Course']['price'])?"Free":"$".$val['Course']['price']; ?></span>
						
					</div>
				</li>
			<?php } }?>	
			</ul>
		</div>
	</div>
</div>
