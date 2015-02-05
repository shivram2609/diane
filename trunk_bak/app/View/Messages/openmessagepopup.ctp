<?php echo $this->Html->script("functionality"); ?>
<div class="open-msg">
<ul id="showmessageuser">
	<li>
	<?php if(!empty($userdetail['Userdetail']['image']) && file_exists($this->webroot.$userdetail['Userdetail']['image'])) { ?>
		<?php echo $this->Html->image($userdetail['Userdetail']['image'],array("alt"=>$userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'])); ?>
	<?php } else { ?>
		<?php echo $this->Html->image("/img/no-img.png",array("alt"=>$userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'])); ?>
	<?php } ?>
	<a href="<?php echo $this->Html->url("/profile/".$userdetail['User']['id'].'/'.$this->Common->makeUrl($userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'])); ?>" style="vertical-align: top;"><?php echo ($userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name']); ?></a>
	</li>
	<li><a href="javascript:void(0);" id="sendmessageid">Send Message</a></li>
</ul>
<?php echo $this->Form->create("Message",array("controller"=>"messages","action"=>"sendmessage")); ?>
<ul style="display:none;" id="messagecontid">
	<li>
		<?php if(!empty($userdetail['Userdetail']['image']) && file_exists($this->webroot.$userdetail['Userdetail']['image'])) { ?>
			<?php echo $this->Html->image($userdetail['Userdetail']['image'],array("alt"=>$userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'],"id"=>"msgusr")); ?>
		<?php } else { ?>
			<?php echo $this->Html->image("/img/no-img.png",array("alt"=>$userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'],"id"=>"msgusr")); ?>
		<?php } ?>
		<?php echo $this->Form->input("User",array("label"=>false,"autocomplete"=>"off","div"=>false,"style"=>"vertical-align:top;","value"=>$userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name'])); ?>
		<?php echo $this->Form->hidden("Userid",array("value"=>$userdetail['User']['id'])); ?>
		<div id="instructcont" class="hide overlaycont"></div>
	</li>
	<li>
		<?php echo $this->Form->input("Message",array("type"=>"textarea")); ?>
	</li>
	<li><?php echo $this->Form->Submit("Send"); ?></li>
</ul>
<?php echo $this->Form->end(); ?>
</div>
