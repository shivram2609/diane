<div class="container">
	<div class="create-course">
		<h1>Join Our Faculty &amp; Teach Online	</h1>
		<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
		<?php echo $this->Session->flash(); ?>
		<div class="cont-box">
			<h2>Create A Course</h2>
			<div class="row">
				<h3>What Technology Course do you want to teach?</h3>
				<span class="lft"><?php echo $this->Form->input('title', array("placeholder"=>"e.g. Learn Programming.", "label"=>false, "div"=>false, "class"=>"","maxlength"=>60,"autocomplete"=>"off")); ?>
				</span>
				<p class="txt-center"><?php echo $this->Form->submit('Create',array("class"=>"save-btn"));?></p>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
