<div class="container">
	<?php echo $this->Session->flash(); ?>
		<div class="clear-fix">&nbsp;</div>
		<?php echo $this->element('userdetailsleft');?>
		<section class="right-panel">
				<h1>Profile<br />
					<span>&nbsp;</span>
				</h1>
				
		<?php echo $this->Form->create('Userdetail'); ?>
		<div class="account-cont">
			<div class="row">
				<div class="profile-titles">
					<h2>Basics</h2>
				</div>
				<span class="lft">
					<?php echo $this->Form->input('designation',array("placeholder"=>"Title","class"=>"controlChars", "div"=>false,"label"=>false,"type"=>"text","maxlength"=>16)); ?>
					<span class="counter"></span>
				</span>
			
				<span class="lft">
					<?php echo $this->Form->input('first_name',array("placeholder"=>"First Name","class"=>"controlChars", "div"=>false,"label"=>false,"type"=>"text","maxlength"=>50)); ?>
					<span class="counter"></span>
				</span>
			
				<span class="lft">
					<?php echo $this->Form->input('last_name',array("placeholder"=>"Last Name","class"=>"controlChars", "div"=>false,"label"=>false,"type"=>"text","maxlength"=>50)); ?>
					<span class="counter"></span>
				</span>
				<span class="lft">
					<?php echo $this->Form->input('heading',array("placeholder"=>"Headline","class"=>"controlChars", "div"=>false,"label"=>false,"type"=>"text","maxlength"=>60)); ?>
					<span class="counter"></span>
				</span> 
				
			</div>
				
			<div class="row">
				<div class="profile-titles">
				<br>
					<h2>Biography</h2>
				<br><br>
				</div>
				<span class="lft"><!-- <img src="img/text-editor.jpg" alt="editor" width="630" height="194" /> -->
				<?php echo $this->Form->input('biography',array("placeholder"=>"Biography", "div"=>false,"label"=>false,"type"=>"textarea")); ?></span>
			
				<span class="lft">
					
					<?php echo $this->Form->input('language',array("id"=>"", "div"=>false,"label"=>false,"type"=>"select","options"=>$languages)); ?>

				</span>
			</div>
				
			<div class="row">
				<div class="profile-titles">
				<h2>Links</h2>
				</div>
				<span class="lft">
					<?php echo $this->Form->input('webLink',array("value"=>"http://","placeholder"=>"Web Link","id"=>"", "div"=>false,"label"=>false,"type"=>"text")); ?>
				</span>
				<span class="lft">
				<?php echo $this->Form->input('gplusLink',array("placeholder"=>"Google Plus Link","id"=>"", "div"=>false,"label"=>false,"type"=>"text")); ?>
				</span>
				<span class="lft"><?php echo $this->Form->input('twitterLink',array("placeholder"=>"Twitter Link","id"=>"", "div"=>false,"label"=>false,"type"=>"text")); ?></span>
				<span class="lft">
				<?php echo $this->Form->input('fbLink',array("placeholder"=>"Facebook Page Link","id"=>"", "div"=>false,"label"=>false,"type"=>"text")); ?>
				</span>
			</div>
		</div>
		<p class="txt-center">
			<?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn ')); ?>
			</p>
		<?php echo $this->Form->end();?>
	</section>		
	</div>
