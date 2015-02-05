<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft'); ?>
	<section class="right-panel">
		<div class="account-cont">
			<h1>
				Notifications<br>
				<span>&nbsp;</span>
			</h1>
			
			<?php echo $this->Form->create('Userdetail'); ?>
			<div class="row">
			<div class="send-box">
				<div class="category-box-text2">
				
						<h2>Send An Email</h2>
				
				</div>
				<div class="check">
					<?php foreach($notifications as $notification): ?>
					<p>
						<?php
						if(!empty($notifi) && in_array($notification['Notification']['id'], $notifi)):
							echo $this->Form->checkbox('notification', array('class'=>'chk_box notifications','hiddenField' => false,'value'=>$notification['Notification']['id'], 'name'=>'data[Userdetail][notifications][]','checked'=>'checked','id'=>"cb_".$notification['Notification']['id']));
						
						else:
							echo $this->Form->checkbox('notification', array('class'=>'chk_box notifications','id'=>"cb_".$notification['Notification']['id'],'hiddenField' => false,'value'=>$notification['Notification']['id'], 'name'=>'data[Userdetail][notifications][]'));
						endif;
						?>
						
						<label for="cb_<?php echo $notification['Notification']['id'];?>" class="chk_lbl"><?php echo $notification['Notification']['notification'];?></label>
						
					</p>
					<?php endforeach;?>
					<p>
					<?php 
					if(empty($notifi)):
							echo $this->Form->checkbox('dontSendNotification', array('class'=>'chk_box','hiddenField' => false,'id'=>'dontSendNotification','checked'=>'checked'));
						else:
							echo $this->Form->checkbox('dontSendNotification', array('class'=>'chk_box','hiddenField' => false,'id'=>'dontSendNotification'));
						endif;
						?>
					<label for="dontSendNotification" class="chk_lbl">Don't send me any email notifications.</label>
					</p>
				</div>
			</div>
			</div></div>
			<p class="txt-center">
				<?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn')); ?>
			</p>
				
			<?php echo $this->Form->end();?>
		</div>
	</section>	
</div>
