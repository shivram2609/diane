<?php //pr($currquestion); ?>
<div class="container">
	<p class="right"><?php if(isset($selfquiz) && !empty($courseid)) { ?>
		<a href="<?php echo $this->Html->url("/course-manage/edit-curriculum/".$courseid); ?>" class="button">Back to Course</a>
	<?php } ?></p>	
	<div class="quiz-cont">
	
	<h1>Quiz</h1>
	<input type="hidden" name="qsttype" id="qsttype" value="<?php echo $currquestion['CourseQuizQuestion']['type']; ?>" />
	<input type="hidden" name="qstid" id="questionid" value="<?php echo $currquestion['CourseQuizQuestion']['id']; ?>" />
	<input type="hidden" name="qtype" id="quiztype" value="<?php echo $type; ?>" />
		<?php if($currquestion['CourseQuizQuestion']['type'] == 'M' || $currquestion['CourseQuizQuestion']['type'] == 'B') { ?>
			<div class="q-box">
				<?php echo nl2br($this->Common->removetags($currquestion['CourseQuizQuestion']['question'])); ?>
			</div>
			<?php foreach($currquestion['CourseQuizQuestionOption'] as $key=>$val) { ?>
				<?php if(isset($selfquiz) && $type != 's' ) { ?>
					<p class="options"><input type="checkbox" value="<?php echo $val['id']; ?>" id="val_<?php echo $val['id']; ?>" disabled <?php echo !empty($val['answer'])?"checked":""; ?> /><label for="val_<?php echo $val['id']; ?>"><?php echo $val['options']; ?></label></p>
				<?php } else { ?>
					<p class="options"><input type="checkbox" value="<?php echo $val['id']; ?>" id="val_<?php echo $val['id']; ?>" class="chkoptionans" /><label for="val_<?php echo $val['id']; ?>"><?php echo $val['options']; ?></label></p>
				<?php } ?>
			<?php }  ?>
		<?php } else { ?>
			<div class="q-box">
				<?php  $qst = $this->Common->getquestion($currquestion['CourseQuizQuestion']['question']); ?>
				<input type="hidden" id="fanswer" value="<?php echo implode('',$qst['answer']); ?>" >
				<?php  echo $qst['string']; ?>
			</div>
			<?php if(isset($selfquiz) && $type != 's' ) { ?>
				<p class="options"><?php echo $currquestion['CourseQuizQuestion']['question']; ?></p>
			<?php } else { ?>
				<p class="options"><?php echo str_replace('_','',str_replace(" __ ","<input type='text' class='fill' />",$qst['string'])); ?></p>
			<?php } ?>
			
		<?php } ?>
		<?php if(isset($selfquiz) && $type != 's') { ?>
			<p class="right"><a href="javascript:void(0);" class="editqstuser" val="<?php echo $currquestion['CourseQuizQuestion']['id']."^".($currindex-1)."_".$quizid; ?>">Edit</a> &nbsp;|&nbsp; <a href="javascript:void(0);" class="deleteqstuser" val="<?php echo $currquestion['CourseQuizQuestion']['id']."^".($currindex-1)."_".$quizid; ?>">Delete</a></p>
			<p class="right" style="display:none;"><a href="javascript:void(0);" class="btn-next nextquestion" val="<?php echo $currquestion['CourseQuizQuestion']['id']; ?>">Submit</a></p>
			<?php if(!isset($lastqst)) { ?>
				<p class="right"><a href="javascript:void(0);" class="btn-next nextquestion" val="<?php echo $currindex."_".$quizid; ?>">Next</a></p>
			<?php } ?>
		<?php } else { ?>
			<?php if(!isset($lastqst)) { ?>
				<p class="right"><a href="javascript:void(0);" class="btn-next submitquestion" val="<?php echo $currindex."_".$quizid; ?>">Next</a></p>
			<?php } else { ?>
				<p class="right"><a href="javascript:void(0);" class="btn-next submitlastquestion" val="<?php echo $currindex."_".$quizid; ?>">Next</a></p>
			<?php } ?>
		<?php } ?>
		<?php if(isset($currindex) && $currindex >1 && isset($selfquiz)) { ?>
			<p class="left"><a href="javascript:void(0);" class="btn-previ nextquestion" val="<?php echo ($currindex-2)."_".$quizid; ?>">Previous</a></p>
		<?php } ?>
	</div>
</div>
