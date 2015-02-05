<?php echo $this->Html->script("extra"); ?>
<?php echo $this->Form->create('CourseQuizQuestion'); ?>
<h1>Quiz</h1>
<div class="q-box">
	<?php echo $this->Form->input('question.'.$currquestion['CourseQuizQuestion']['id'],array("value"=>$currquestion['CourseQuizQuestion']['question'],"type"=>"textarea","div"=>false,"label"=>false,"cols"=>"135","row"=>"10")); ?>
</div>
<?php if($currquestion['CourseQuizQuestion']['type'] == 'M' || $currquestion['CourseQuizQuestion']['type'] == 'B') { ?>
	<?php foreach($currquestion['CourseQuizQuestionOption'] as $key=>$val) { ?>
		<p class="options">
			<?php 
				echo $this->Form->checkbox("CourseQuizQuestionOption.answer.".$val['id'],array("label"=>false,"div"=>false,!empty($val['answer'])?"checked":"","class"=>"chkoptionans")); 
				if ($currquestion['CourseQuizQuestion']['type'] == 'M')  {
					echo $this->Form->input("CourseQuizQuestionOption.options.".$val['id'],array("value"=>$val['options'],"label"=>false,"div"=>false)); 
				} else {
					echo $val['options']; 
				}
			?>
		</p>
	<?php }  ?>
<?php }
?>
<a href="javascript:void(0);" class="button nextquestion" val="<?php echo $previd; ?>">Cancel</a>
<?php
echo $this->Form->submit("Submit",array("class"=>"button mrgn","div"=>false,"label"=>false));
echo $this->Form->end(); ?>
