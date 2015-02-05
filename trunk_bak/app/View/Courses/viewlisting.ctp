<?php if($type == "notes") {
?>
<?php foreach($data as $key=>$val) { ?>
		<?php echo h($val['CourseUserNote']['notes']); ?>
<?php } 
}
if($type == "questions") {
?>
<?php
	foreach($data as $key=>$val) {
		?>
		<li>
			<a href="<?php echo $this->Html->url("/question/".$val['CourseUserQuestion']['id']); ?>" class="openquestionpop"><?php echo h($val['CourseUserQuestion']['question']); ?></a> 	<span class="right"><?php echo date("M d",strtotime($val['CourseUserQuestion']['created'])); ?></span>
		</li>
		<?php
	}
}
?>
<?php echo $this->Html->script("jquery.colorbox"); ?>
<?php echo $this->Html->css("colorbox"); ?>
<?php echo $this->Colorbox->openexternalpopups ("openquestionpop","600px","540px"); ?>
