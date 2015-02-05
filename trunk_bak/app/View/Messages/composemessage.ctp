<div class="container">
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element("messageleft"); ?>
	
	<?php echo $this->Session->flash(); ?>
	<section class="right-panel">
		<div>&nbsp;</div>
		<?php // echo $this->element("searchmessage"); ?>
			<div>
			<?php echo $this->Form->create("Message",array("controller"=>"messages","action"=>"sendmessage")); ?>
			<ul id="messagecontid">
				<li>
						<div class="msg-row-od"><?php echo $this->Html->image("/img/no-img.png",array("alt"=>"","id"=>"msgusr")); ?>
							<?php echo $this->Form->input("User",array("label"=>false,"autocomplete"=>"off","div"=>false,"style"=>"vertical-align:top;","value"=>"","placeholder"=>"Search contacts here")); ?>
							<div id="instructcont" class="hide overlaycont"></div>
						</div>
						<div class="msg-row-od"><?php echo $this->Form->input("Message",array("type"=>"textarea")); ?></div>
						<div class="msg-row-od txt-center"><?php echo $this->Form->Submit("Send",array("class"=>"button")); ?></div>
					<?php echo $this->Form->hidden("Userid",array("value"=>"")); ?>
					
				</li>
			</ul>
			<?php echo $this->Form->end(); ?>
			</div>
	</section>
</div>

