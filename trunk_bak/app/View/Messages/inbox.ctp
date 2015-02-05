<?php echo $this->Session->flash(); ?>
<div class="container">
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element("messageleft"); ?>
	
	
	<section class="right-panel">
		<div>&nbsp;</div>
		<?php echo $this->element("searchmessage"); ?>
		<?php echo $this->Form->create("Message"); ?>
		
		<?php $i = 1;?>
		<?php if(empty($messages)) { ?>
			<div class="msg-row-<?php echo (($i%2) == 0)?'even':'od'; ?>">
				No Message Found
			</div>
		<?php } else { ?> 
			<?php foreach ($messages as $message) { ?>
				<div class="msg-row-<?php echo (($i%2) == 0)?'even':'od'; ?>">
					<img src="<?php echo $this->webroot;?>img/dummy-img-msg.png" width="40" height="40" alt="Craig" class="msg-img" />
					<div class="msg-img-txt">
						<?php echo $message['Sender']['first_name'].' '.$message['Sender']['last_name'].','.$message['Reciever']['first_name'].' '.$message['Reciever']['last_name']; ?><span>(<?php echo $message[0]['countmessage']; ?>)</span><br/>
						<span class="date"><?php echo date("M d",strtotime($message['Message']['created'])); ?></span>
					</div>
					<div class="msg-img-txt-rt">
						<!--<span><a href="javascript:void(0);" title="Non Profit">Non Profit</a></span><br />-->
						<a href="<?php echo $this->Html->url(array('controller'=>'message','action' =>$message['Message']['message_id'],'inbox')); ?>" class="txt-msg"><?php echo $this->Common->removehtml($message['Message']['newmessage'],100); ?></a>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<?php echo $this->Form->end();?>
	
	</section>
	<?php if(count($messages)>9 || isset($this->params['named']['page'])) : ?>
	<div class="pagination-box">
		<?php
			echo $this->Paginator->prev(('Prev'), array(), null, array('class' => 'prev_pagination_lnk disabled pge-no active-pagination'));
			echo $this->Paginator->numbers(array('separator' => '',"class"=>"pge_no"));
			echo $this->Paginator->next(__('Next'), array(), null, array('class' => 'next_pagination_lnk disabled'));
		?>
	</div>
	<?php endif;?>
</div>
