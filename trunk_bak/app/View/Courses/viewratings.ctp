<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="wish-list">
		<?php if(isset($title_for_layout)) { ?>
			<h1><?php echo $title_for_layout; ?></h1>
		<?php } ?>
		<div class="listing">
	<?php if(!empty($coursereviews)) { ?>
		<ul>
		<?php
		foreach ($coursereviews as $key=>$val) {
			?>
			<li>
				<div class="img">
					<?php 
						// use thumb path from helper
						$courseImgPathThumb1 = ((!empty($val['Userdetail']['image']) && file_exists(WWW_ROOT.$val['Userdetail']['image']))?$val['Userdetail']['image']: "/img/no-img.png");
						$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, 'msmallProfile_');
						echo $this->Html->image($courseImgThumb1,array("alt"=>$val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name'],"width"=>"112px","height"=>"112px"));
					?>
				</div>
				<div class="txt">
					<h2><?php echo ucwords($val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']); ?></h2>
					<p><?php echo $val['CourseReview']['review_text']; ?></p>
					<span class="rating_star"><?php echo $this->element("ratingstars",array("rating"=>$val['CourseReview']['avgrating'])); ?></span>
				</div>
			</li>
			<?php
		}
		?>
		</ul>
		<?php }else{ ?>
			<?php
				//echo "No Results Found!";
			?>
		</div>
		<?php } ?>
	</div>
</div>
<?php if(count($coursereviews) > 19 || isset($this->params['named']['page'])) { ?>
	 	<div class="pagination-box">
			<div class="paging">
				<span class="prev-pagination-lnk"><?php echo $this->Paginator->prev('< ' . __('Prev  '), array(), null, array('class' => 'prev disabled')); ?></span>
				<span class="pge-no"><?php echo $this->Paginator->numbers(array('separator' => '</span><span class="pge-no">'));?></span>
				<span class="next-pagination-lnk"><?php echo $this->Paginator->next(__('Next >'), array(), null, array('class' => 'next disabled'));?></span>
			</div>
		</div>
	<?php } ?>
</div>
<?php //echo $this->element("paging"); ?>
