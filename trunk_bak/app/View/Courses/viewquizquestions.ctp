<ul class="view-qusetion viewqusetion<?php echo $id; ?>" >
 <?php if(empty($questions)) { ?>
 <?php } else { ?>
	<?php foreach($questions as $key=>$val) { 
		if(!empty($val['CourseQuizQuestionOption']) || $val['CourseQuizQuestion']['type'] == 'F' ) {
		?>
		<h2>Question : <?php echo strip_tags($val['CourseQuizQuestion']['question']); ?></h2>
		<li>&nbsp;</li>
		<?php if($val['CourseQuizQuestion']['type'] != 'F') { ?>
			<li>Options:</li>
				<?php $i = 1; foreach($val['CourseQuizQuestionOption'] as $key1=>$val1) { ?>
					<?php if(!empty($val1['options'])) { 
						?>
						<li>Option <?php echo $i++; ?> <?php echo $val1['options']; ?>&nbsp; <?php echo (!empty($val1['answer'])?'(Answer)':''); ?></li>
					<?php } ?>
				<?php } ?>
		<?php } ?>
		<?php 
		} ?>
	<?php } ?>
<?php } ?>
</ul>
