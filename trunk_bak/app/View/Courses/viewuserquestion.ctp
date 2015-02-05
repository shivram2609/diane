<style>
#wrapper {background:none;}
</style>
<?php echo $this->Form->create("CourseUserQuestionAnswer"); ?>
<?php echo $this->Session->flash(); ?>
		<div class="container">
			<div class="review-list">
				
				<h1><em>&nbsp;</em>Question &amp; Answers</h1>

				<div class="add-q-contnt">
					<?php foreach($data as $key=>$val) { ?>
						<h2><span class="q-mark">&nbsp;</span> <?php echo $this->Common->removetags(nl2br($val['CourseUserQuestion']['heading'])); ?></h2>
						<?php echo $this->Common->removetags(nl2br($val['CourseUserQuestion']['question'])); ?>
						<ul class="by-day-com">
							<li>Asked by: <span><?php echo $val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']; ?></span></li>
							<li><?php echo $this->Common->otherDiffDate($val['CourseUserQuestion']['created']); ?></li>
						</ul>
						<div class="clear-fix">&nbsp;</div>
						<?php if(!empty($val['CourseUserQuestionAnswer'])) { ?>
						<?php foreach($val['CourseUserQuestionAnswer'] as $anskey=>$ansval) { ?>
							<div class="answer">
								<?php echo $this->Common->removetags(nl2br($ansval['answer'])); ?>
								<ul class="by-day-com">
									<li>Asked by: <span><?php echo h($ansval['username']); ?></span></li>
									<li><?php echo $this->Common->otherDiffDate($ansval['created']); ?></li>
								</ul>
							</div>
						<?php }
						} ?>
					<?php } ?>
					<?php echo $this->Form->input("answer",array("type"=>"textarea","label"=>false,"div"=>false,"cols"=>"60"));  ?>
					<?php echo $this->Form->submit("Add Comment",array("class"=>"button-1")); ?>
					<div class="clear-fix">&nbsp;</div>
				</div>
				
				<div class="bdr-top clear-fix"></div>
			</div>
		</div>
<!--====Body Section End====-->
<?php echo $this->Form->end(); ?>
