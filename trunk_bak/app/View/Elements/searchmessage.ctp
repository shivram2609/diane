<!--a href="#" class="new_msg_btn"></a-->
<?php echo $this->Form->create("Message"); ?>
<div class="message_search">
	<?php echo $this->Form->input("searchval",array("div"=>false,"label"=>false,"placeholder"=>"Search by Subject / Message")); ?>
</div>
<?php echo $this->Form->end(); ?>
