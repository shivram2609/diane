<div class="addquestionnew">
<?php echo $this->Form->input("CourseQuizQuestion.question",array("type"=>"textarea","label"=>"Question")); ?>
<?php echo $this->Form->input("CourseQuizQuestion.course_quiz_id",array("type"=>"hidden","label"=>false,"div"=>false,"value"=>$id)); ?>
<?php if($data['questiontype'] == 'fill') { ?>
<div id="fillquestion"><em class="tip-txt">*Info: You can phrase these Questions like the example shown below, by adding the underscores "_" around the word that you would like to show as blank. For e.g.<br/>This is a _good_ example of fill in the blanks.<br/>The question will appear to the user as:<br/>This is a __ example of fill in the blanks. and the text "good" is the answer.</em></div>
<?php } ?>
<?php if($data['questiontype'] == 'mul' || $data['questiontype'] == 'truefalse' ) { ?>
	<br><label>Options</label>
<?php } ?>
<ul class="newoptions" >
	<?php if($data['questiontype'] == 'mul') { ?>
		<?php echo $this->Form->input("CourseQuizQuestion.type",array("type"=>"hidden","label"=>false,"div"=>false,"value"=>"M")); ?>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.answer.1",array("type"=>"checkbox","label"=>false,"div"=>false,"class"=>"optquestion")); ?> <?php echo $this->Form->input("CourseQuizQuestionOption.options.1",array("type"=>"text","label"=>false,"div"=>false,"class"=>"optquestionval","maxlength"=>"150")); ?></li>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.answer.2",array("type"=>"checkbox","label"=>false,"div"=>false,"class"=>"optquestion")); ?> <?php echo $this->Form->input("CourseQuizQuestionOption.options.2",array("type"=>"text","label"=>false,"div"=>false,"class"=>"optquestionval","maxlength"=>"150")); ?></li>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.answer.3",array("type"=>"checkbox","label"=>false,"div"=>false,"class"=>"optquestion")); ?> <?php echo $this->Form->input("CourseQuizQuestionOption.options.3",array("type"=>"text","label"=>false,"div"=>false,"class"=>"optquestionval","maxlength"=>"150")); ?></li>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.answer.4",array("type"=>"checkbox","label"=>false,"div"=>false,"class"=>"optquestion")); ?> <?php echo $this->Form->input("CourseQuizQuestionOption.options.4",array("type"=>"text","label"=>false,"div"=>false,"class"=>"optquestionval","maxlength"=>"150")); ?></li>
	<?php } elseif($data['questiontype'] == 'truefalse') { ?>
		<?php echo $this->Form->input("CourseQuizQuestion.type",array("type"=>"hidden","label"=>false,"div"=>false,"value"=>"B")); ?>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.options.1",array("type"=>"checkbox","label"=>"True","div"=>false,"class"=>"optquestion")); ?> </li>
		<li><?php echo $this->Form->input("CourseQuizQuestionOption.options.2",array("type"=>"checkbox","label"=>"False","div"=>false,"class"=>"optquestion")); ?> </li>
	<?php } elseif($data['questiontype'] == 'fill') { ?>
		<?php echo $this->Form->input("CourseQuizQuestion.type",array("type"=>"hidden","label"=>false,"div"=>false,"value"=>"F")); ?>
	<?php } ?>
	
</ul>
<p style="color:red;display:none;" id="questionerr"></p><br/>
<?php echo $this->Form->submit("Submit",array("id"=>"addquizbtn")); ?>
</div>

