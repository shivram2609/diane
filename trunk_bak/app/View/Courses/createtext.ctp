<?php echo $this->Html->script(array('jquery.1.8.2','jquery.form')); ?>
<?php echo $this->Html->script('ckeditor/ckeditor');  ?>
<?php echo $this->Form->input("Text.".$id,array("type"=>"textarea","class"=>"addtext","label"=>"Text","id"=>"text")); ?>
<label class="errmsg hide"></label>
<?php echo $this->Form->submit("Save"); ?>
<?php echo $this->Fck->loadlecturecontent('text'); ?>
