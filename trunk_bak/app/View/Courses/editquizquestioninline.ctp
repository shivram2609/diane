<?php echo $this->Html->script("extra"); ?>
<?php echo $this->Form->create('CourseQuizQuestion'); ?>
<p class="question-heading">Edit Question</p>
<div class="q-box1">
	<?php echo $this->Form->input('question.'.$currquestion['CourseQuizQuestion']['id'],array("value"=>$currquestion['CourseQuizQuestion']['question'],"type"=>"textarea","div"=>false,"label"=>false,"cols"=>"135","row"=>"10")); ?>
</div>
<?php if($currquestion['CourseQuizQuestion']['type'] == 'M' || $currquestion['CourseQuizQuestion']['type'] == 'B') { ?>
	<?php foreach($currquestion['CourseQuizQuestionOption'] as $key=>$val) { ?>
		<div class="clear">
		<span class="options">
			<?php 
				echo $this->Form->checkbox("CourseQuizQuestionOption.answer.".$val['id'],array("label"=>false,"div"=>false,!empty($val['answer'])?"checked":"","class"=>"chkoptionans")); 
				if ($currquestion['CourseQuizQuestion']['type'] == 'M')  {
					echo $this->Form->input("CourseQuizQuestionOption.options.".$val['id'],array("value"=>$val['options'],"label"=>false,"div"=>false,"class"=>"question-input")); 
				} else {
					echo $val['options']; 
				}
			?>
		</span>
		</div>
	<?php }  ?>
<?php } ?>
<a href="javascript:void(0);" id="cancleqst" class="module-btn1">Cancel</a>
<?php echo $this->Form->submit("Submit",array("class"=>"module-btn2 mrgn","div"=>false,"label"=>false));
echo $this->Form->end(); ?>
