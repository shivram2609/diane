<?php echo $this->Session->Flash(); ?>
<div class="container">
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element("messageleft"); ?>
	<section class="right-panel">
		<div>&nbsp;</div>

				<div class="view_msg_top_strip">
					<?php //pr($message); ?>
					<?php if (isset($trashstatus)) { ?>
					<a href="<?php echo $this->Html->url(array('controller' => 'movetrash','action'=>$message[0]['Message']['message_id'])); ?>" class="fav_bx trashbx"><span class="trash-top"></span>Move to Trash</a>
					<?php } ?>
					<?php if (isset($removestatus)) { ?>
					<a href="<?php echo $this->Html->url(array('controller' => 'removemessage','action'=>$id)); ?>" class="fav_bx trashbx" onclick="return confirm('Do you really want to delete this message?');"><span class="trash-top"></span> Delete Message</a>
					<?php } ?>
					<!--a href="#" class="fav_bx"><span class="favrite-top"></span>Favourite</a-->
				</div>
				
				<?php $i = 1;?>
				<?php foreach($message as $key=>$val) { ?>
				<?php if($i == 1 || $i == count($message) ) { ?>
					<div class="msg-row-<?php echo (($i%2) == 0)?'evn':'od'; ?>">
						<div class="msg-img-txt">
							<a href="<?php echo $this->Html->url("/profile/".$val['Message']['sender_id']."/".$this->Common->makeUrl($val['Sender']['first_name'].' '.$val['Sender']['last_name'])); ?>"><?php echo ($val['Sender']['first_name'].' '.$val['Sender']['last_name']); ?></a>
							<span class="date"><?php echo date("M d",strtotime($val['Message']['created'])); ?></span>
						</div>
						<div class="msg-img-txt-rt">
							<?php echo strip_tags(nl2br($val['Message']['message']),"<p>,<span>,<br>"); ?>
						</div>
					</div>
				<?php } elseif((count($message)-1) >2 && $i == 2) { ?>
					<div class="msg-row-<?php echo (($i%2) == 0)?'evn':'od'; ?> view-all">
						<div class="msg-img-txt view-all-message-on-click">
							View all <?php echo count($message)-1; ?> Messages.
						</div>
					</div>
				<?php } else { 
					?>
					<div class="msg-row-<?php echo (($i%2) == 0)?'evn':'od'; ?>" style="display:none;">
						<div class="msg-img-txt">
							<a href="<?php echo $this->Html->url("/profile/".$val['Message']['sender_id']."/".$this->Common->makeUrl($val['Sender']['first_name'].' '.$val['Sender']['last_name'])); ?>"><?php echo ($val['Sender']['first_name'].' '.$val['Sender']['last_name']); ?></a>
							<span class="date"><?php echo date("M d",strtotime($val['Message']['created'])); ?></span>
						</div>
						<div class="msg-img-txt-rt">
							<?php echo strip_tags(nl2br($val['Message']['message']),"<p>,<span>,<br>"); ?>
						</div>
					</div>
				<?php } ?>
				<?php $i++; ?>
				<?php } ?>
				
				<?php if(!isset($removestatus)) { ?>
				<?php echo $this->Form->create("Message"); ?>
				<div class="reply_box">
					<h2 class="reply_heading">Reply</h2>
					<?php echo $this->Form->input("message",array("div"=>false,"label"=>false)); ?>
					<?php echo $this->Form->hidden("message_id",array("value"=>$message[0]['Message']['message_id']));  ?>
					<?php if(isset($trashstatus)) { 
						echo $this->Form->hidden("reciever_id",array("value"=>$message[0]['Sender']['user_id'])); 
					 } elseif(isset($sentstatus)) { 
						echo $this->Form->hidden("reciever_id",array("value"=>$message[0]['Reciever']['user_id']));
					 } ?>
				</div>
				<div class="msg-row-od txt-center"><?php echo $this->Form->submit("Send",array("div"=>false,"label"=>false,"class"=>"button msg_send_btn")); ?>
				</div>
				<?php echo $this->Form->end(); ?>
				<?php } ?>
				
		</section>
		
</div>

