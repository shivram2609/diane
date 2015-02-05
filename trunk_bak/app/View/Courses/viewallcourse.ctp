<div class="container">
	<div class="wish-list">
		<?php if(isset($usercourses[0]['Course']['name'])) { ?>
			<h1>All Courses By <?php echo ucwords($usercourses[0]['Course']['name']); ?> </h1>
		<?php } ?>
		<div class="listing">
			<?php if(!empty($usercourses)) { ?>
			<ul>
				<?php foreach ($usercourses as $key=>$val) {
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
							<a href="<?php echo $this->Html->url('/c'."/".$val['Course']['id']."/".$this->Common->makeUrl($val['Course']['title'])); ?>" title="<?php echo h($val['Course']['title']); ?>"><?php echo h($val['Course']['title']); ?></a>
						</h2>	
						<p>
							<a href="<?php echo $this->Html->url('/c'."/".$val['Course']['id']."/".$this->Common->makeUrl($val['Course']['title'])); ?>" title="<?php echo h($val['Course']['title']); ?>"><?php echo $this->Common->removetags(substr($val['Course']['summary'],0,500),array("<br>","<i>","b")); echo (strlen($val['Course']['summary']) > 500?" ...":""); ?>  </a>
						</p>
						<span class="rating_star">
							<?php echo $this->element("ratingstars",array("rating"=>$val['Course']['avgrating'])); ?>
						</span>	
						<a href="<?=$this->Html->url("/profile/".$val['Course']['user_id']."/".$this->Common->makeurl($val['Course']['name'])); ?>"><?=ucwords($val['Course']['name']); ?></a>
						<span class="users">
							<img src="<?php echo $this->webroot; ?>img/user-icon-gry.png" alt="" width="24" height="16" /> <?php echo $val['Course']['students']; ?>
						</span>
						<span class="pric"><?php echo empty($val['Course']['price'])?"Free":"$".$val['Course']['price']; ?></span>
					</div>
				</li>
				<?php
			}
			?>
		   </ul>
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
		</div>
	</div>
	<?php if(count($usercourses) > 19 || isset($this->params['named']['page'])) { ?>
	<div class="pagination-box">
		<div class="paging">
			<span class="prev-pagination-lnk"><?php echo $this->Paginator->prev('< ' . __('Prev  '), array(), null, array('class' => 'prev disabled')); ?></span>
			<span class="pge-no"><?php echo $this->Paginator->numbers(array('separator' => '</span><span class="pge-no">'));?></span>
			<span class="next-pagination-lnk"><?php echo $this->Paginator->next(__('Next >'), array(), null, array('class' => 'next disabled'));?></span>
		</div>
	</div>
	<?php } ?>
</div>
