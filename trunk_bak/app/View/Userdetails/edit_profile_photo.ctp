<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element("userdetailsleft"); ?>
	<section class="right-panel">
		<div class="privacy">
			<h1>Profile Photo<br />
				<span>&nbsp;</span>
			</h1>
			
		<div class="image-outer">
				
		<div class="category-box-text2">
		<br><br><br>
		<h2>Profile Preview</h2>
		<br><br><br>
		</div>	
			<div class="img-content">
				<div class="img-frame">
					<?php 
					// use thumb path from helper
					$profileImgPathThumb1 = (($this->Session->read("Auth.User.Userdetail.image") && file_exists(WWW_ROOT.$this->Session->read("Auth.User.Userdetail.image")))?$this->Session->read("Auth.User.Userdetail.image"): "/img/no_img.png");
					$profileImgThumb1 = $this->Common->getImageName($profileImgPathThumb1, LargeProfileImagePrefix);
					echo $this->Html->image($profileImgThumb1,array("alt"=>$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"),"width"=>"210px","height"=>"210px"));
					
					?>
				</div>
				<!-- <p><strong>TIP:</strong> Your beautiful, clean, non-pixelated image should be at minimum 200x200 pixels.</p> -->
			</div>
			<div class="upload-pic">
		
			<div class="input_full blog_select upload_default_theme">
				<div class="input file">
					<div class="uploader" id="uniform-PhotoFile" style="">
						<?php echo $this->Form->create('Userdetail',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
						
						<?php echo $this->Form->input('image',array("type"=>"file","class"=>"TxtFld upload_default","label"=>false,"div"=>false,"id"=>"PhotoFile")); ?>
						<?php echo $this->Form->hidden('id',array('id'=>$this->data['Userdetail']['id']));?>	
						<span class="filename" style="-moz-user-select: none;">Image files must be .jpg, .jpeg, .gif, .png, .bmp</span>
						<span class="action" style="-moz-user-select: none;">Browse</span>
						<?php echo $this->Form->Submit("Upload Image File",array('label'=>false,'div'=>false,'class'=>'action')); ?>
					</div>
				</div>				
			</div>
		</div>
		</div>
		
	</div>
  </section>		
</div>
