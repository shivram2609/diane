<?php echo $this->Html->script("extra"); ?>
<h1>Quiz Result</h1>
<div class="q-box">
	Following are the details for the quiz.
</div>
<p class="options">Total Questions	: <?php echo $this->Session->read("result.".$quizid.".totalquestion"); ?></p>
<p class="options">Correct Answers	: <?php echo $this->Session->read("result.".$quizid.".marks"); ?></p>
<p class="options">Percentage		: <?php echo number_format((($this->Session->read("result.".$quizid.".marks")/$this->Session->read("result.".$quizid.".totalquestion"))*100),"2",".",""); ?></p>
<p class="right"><a href="<?php echo $this->Html->url("/view-courses"); ?>" class="button">View Courses</a></p>
<p class="right" style="float:left;"><a href="<?php echo $this->Html->url("/q/".$quizid); ?>" class="button">Retake this Quiz</a></p>
<br/>
	<p class="clear-fix"></p>
	<div class="bdr-fram">
		<div class="rw">
			<p class="qstn options">Questions</p>
			<p class="ansr">You Answers</p>
		</div>
		<?php foreach($_SESSION["answerquiz"][$quizid] as $key=>$val) { // pr($val); ?>
			<?php if(!empty($val['displayquestion'])) { ?>
			<div class="rw">
				<p class="qstn options">
					<?php if(empty($val["question"])) { echo strip_tags($val["displayquestion"]); } else { $qst = $this->Common->getquestion($val["displayquestion"]); echo strip_tags($qst['string']); } ?>
				</p>
					<?php if(empty($val['answerflag'])) { ?>
						<p class="ansr" style="color:red;"><?php echo rtrim($val["rawanswer"],","); ?></p>
					<?php } else { ?>
						<p class="ansr" style="color:green;"><?php echo rtrim($val["rawanswer"],","); ?></p>
					<?php } ?>
			</div>
			<?php } ?>
		<?php } ?>
	</div>

<?php 
	unset($_SESSION["quizquestions"]);
	unset($_SESSION["currentqst"]);
	unset($_SESSION["answerquiz"]);
	unset($_SESSION["result"][$quizid]);
?>
