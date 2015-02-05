<div class="container">
<?php echo $this->element('coursesLeft');?>
<section class="right-panel">
	<h1>Course Summary<br /></h1>
	<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data")); ?>
	<div class="summary-cont">
		<div class="row">
			<div class="category-box-text">
				<p>&nbsp;</p>
				<h2>Course Summary</h2>
				<p>&nbsp;</p>
			</div>
			<div class="right"><!-- <span class="tooltip" href="tool_tip1" onmouseover="tooltip.pop(this, '#tool_tip1')"> -->
				<span class="lft"><?php echo $this->Form->input('summary',array('type'=>'textarea','label'=>false, 'div'=>false)); ?></span> 
				<?php /*<span class="rt"><a href="javascript:void(0);" id="helpMe" title="Help"><img src="<?php echo $this->webroot;?>img/question.png" width="38" height="38" alt="" /></a></span>*/ ?>
			</span>
			</div>
		</div>
		<?php /*
		<div class="row">
			<h3>Course Goal and Objectives:</h3>
			
				<?php if(isset($viewcoursegoals) && !empty($viewcoursegoals)) { 
					$coursegoals = unserialize($viewcoursegoals['CourseGoal']['title']);
					?>
				<span class="lft">
				<?php
				$i = 1;
				foreach ($coursegoals as $key=>$val) {
					echo $this->Form->input('CourseGoal.title.'.$i,array("label"=>false,"div"=>false,"maxlength"=>100,"value"=>$val,"class"=>($i>1)?"goals goalsextra":"goals"));
					if($i > 1) {
						?>
						<a class="remgoal fltrght" id="<?php echo $i; ?>" href="javascript:void(0)">Remove</a>
						<?php
					}
					$i++;
				}
				?>
				</span>
				<?php
				 } else { ?>
					<span class="lft"><?php echo $this->Form->input('CourseGoal.title.1',array("label"=>false,"maxlength"=>100,"div"=>false,"class"=>"goals")); ?></span>
				<?php } ?>
				<span class="tooltip" href="tool_tip2" onmouseover="tooltip.pop(this, '#tool_tip2')">
				<span class="rt" id="addgoals"><img src="<?php echo $this->webroot;?>img/add-icon.png" width="35" height="35" alt="" /></span>
			</span>
		</div>	
		<div class="row">
			<h3>Intended Audience:</h3>
			<span class="tooltip">
				<?php if(isset($viewcourseaudience) && !empty($viewcourseaudience)) { 
				$courseaudience = unserialize($viewcourseaudience['CourseAudience']['title']);
				?>
				<span class="lft">
					<?php
					$j = 1;
					foreach ($courseaudience as $key=>$val) {
						echo $this->Form->input('CourseAudience.title.'.$j,array("label"=>false,"maxlength"=>100,"div"=>false,"value"=>$val,"class"=>($j>1)?"audience goalsextra":"audience"));
						if($j > 1) {
						?>
						<a class="remaudience fltrght" id="<?php echo $j; ?>" href="javascript:void(0)">Remove</a>
						<?php
						}
						$j++;
					}
					?>
				 </span>
					<?php
					} else { ?>
				 <span class="lft"><?php echo $this->Form->input('CourseAudience.title.1',array("label"=>false,"div"=>false,"class"=>"audience","maxlength"=>100)); ?></span>
				<?php } ?>
				<span class="rt" id="addaudience" onmouseover="tooltip.pop(this, '#tool_tip3')"><img src="<?php echo $this->webroot;?>img/add-icon.png" width="35" height="35" alt="" /></span>
			</span>
		</div>
		<div class="row">
			<h3>Course Requirements:</h3>
			<span class="tooltip">
				<?php if(isset($viewcourserequirement) && !empty($viewcourserequirement)) { 
				$courserequirement = unserialize($viewcourserequirement['CourseRequirement']['title']);
				?>
				<span class="lft">
				<?php
				$k = 1;
				foreach ($courserequirement as $key=>$val) {
					
					echo $this->Form->input('CourseRequirement.title.'.$k,array("label"=>false,"maxlength"=>100,"div"=>false,"value"=>$val,"class"=>($k>1)?"requirement goalsextra":"requirement"));
					if($k > 1) {
						?>
						<a class="remrequirement fltrght" id="<?php echo $k; ?>" href="javascript:void(0)">Remove</a>
						<?php
					}
					$k++;
				}
				?>
				</span>
				<?php
				} else { ?>
				<span class="lft"><?php echo $this->Form->input('CourseRequirement.title.1',array("label"=>false,"maxlength"=>100,"div"=>false,"class"=>"requirement")); ?></span>
				<?php } ?>
				<span class="rt" id="addrequirement" onmouseover="tooltip.pop(this, '#tool_tip4')"><img src="<?php echo $this->webroot;?>img/add-icon.png" width="35" height="35" alt="" /></span>
			</span>
		</div> */ ?>
		<div class="row">
		<div class="category-box-text">
				<h2>Instruction Level</h2>
				</div>
			<div class="right">
				<span class="lft">
					<?php
						echo $this->Form->input('instruction_level_id', array('div'=>false,'type'=>'radio','legend'=>false,'options'=>$instlevel,'value'=>empty($this->data['Course']['instruction_level_id'])?'4':$this->data['Course']['instruction_level_id']));
					?>
				</span>
			</div>
		</div>
	</div>
	<p class="txt-center btn-padding"><?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'save-btn')); ?></p>
	<?php echo $this->Form->end();?>
</section>
	
</div>
