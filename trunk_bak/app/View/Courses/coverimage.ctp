<div class="container">
	<?php echo $this->element('coursesLeft');?>
	<section class="right-panel">
		<h1>Cover Image</h1><br/>
	
		<div class="image-outer1">
		
		<div class="category-box-text"><h2>Image Preview</h2>
		Image should be a minimum of 480x720.
		</div>	
		<div class="rt-txt"><p class="txt-center"></p>
			 <?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
				<h3>Add/Change image:</h3>
				<div class="input_full blog_select upload_default_theme">
		
				<div class="input file">
					<div class="uploader" id="uniform-PhotoFile" style="">
						<?php echo $this->Form->input('coverimage',array("class"=>"TxtFld upload_default", "type"=>"file","div"=>false,"label"=>false)); ?>
						<span class="filename" style="-moz-user-select: none;">Image files must be .jpg, .jpeg, .gif, .png, .bmp</span>
						<span class="action" style="-moz-user-select: none;">Browse</span>
						
					</div>
					<p><?php echo $this->Form->Submit("Upload Image File",array('label'=>false,'div'=>false,'class'=>'action')); ?></p>
				</div>				
			</div>
			<?php echo $this->Form->end();?>
		</div>
		<div class="clear-fix"></div>
			<div class="img-frame1">
				<?php 
				// use thumb path from helper
				$courseImgPathThumb1 = ((!empty($this->data['Course']['coverimage']) && file_exists(WWW_ROOT.$this->data['Course']['coverimage']))?$this->data['Course']['coverimage']: "/img/no_img.png");
				$courseImgThumb1 = $this->Common->getImageName($courseImgPathThumb1, LargeCourseImagePrefix);
				echo $this->Html->image($courseImgThumb1,array("alt"=>"","width"=>"513px","height"=>"211px"));
				
				?>
				
				<?php //echo $this->Html->image($this->data['Course']['coverimage']); ?></div>
			
			
			</div>
			
			
	
	</section>
</div>
