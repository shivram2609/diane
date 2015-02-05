<?php
if($listflag && isset($abc)) {
?>
<!-- search code below -->
<div class="search-box">
	<?php echo $this->Form->input("searchval",array("type"=>'text',"placeholder"=>$place,"div"=>false,"label"=>false)); ?>
	<?php echo $this->Form->submit("Search",array("label"=>false,"div"=>false,"class"=>'invite-button nomargin submitsearch',"id"=>'submitbtn',"attr"=>'search'));
	if($flag){
	?>
	<br/><span style="font-size:11px;"><i>date format : yyyy-mm-dd</i><span>
	<?php } ?>
</div>
<!-- search code ends here -->

<!-- page heading and add button below -->
<h2><?php echo __($pageheader);?></h2>

<!-- end here -->
<div class="clear"></div>
<!-- bulk action code below -->
<?php
	echo $this->Form->input("options",array("options"=>array(""=>'Select Action',$options),"div"=>false,"label"=>false,"class"=>'options '.(isset($class)?$class:''),"style"=>""));
	echo $this->Form->submit("Submit",array("div"=>false,"label"=>false,"id"=>'submitbtn',"class"=>'submit',"style"=>'float: left;margin: 0 0 0 13px;position: absolute;'));
?>
<label class="error" id="checkerr" style="float: left; margin: -10px 0 0;"></label>
<div class="clear"></div>
<!-- end here -->
<?php
}

?>
<h1 class="sent_message_heading"><?php echo __($pageheader);?></h1>
<?php echo $this->Session->flash(); ?>
<div class="top_msg_section">
	<div class="message_search snt_msg_srch">
		<?php echo $this->Form->input("searchval",array("type"=>'text',"placeholder"=>$place,"div"=>false,"label"=>false)); ?>
		<!--input type="text" value="Search by Campaign" onfocus="if(this.value=='Search by Campaign')this.value=''" onblur="if(this.value=='')this.value='Search by Campaign'" /-->
	</div>
	<!--a href="#" class="snt_srch_btn">Search</a-->
	<?php echo $this->Form->submit("Search",array("label"=>false,"div"=>false,"class"=>'snt_srch_btn submitsearch',"id"=>'submitbtn',"attr"=>'search')); ?>
	
	<?php echo $this->Form->submit("Submit",array("div"=>false,"label"=>false,"id"=>'submitbtn',"class"=>'submit snt_srch_btn right')); ?>
	<div class="select_action_sbmt">
		<?php
		echo $this->Form->input("options",array("options"=>array(""=>'Select Action',$options),"div"=>true,"label"=>false,"class"=>'options '.(isset($class)?$class:''),"style"=>""));
	 ?>
	 <label class="error" id="checkerr"></label>
	</div>
	
<div>
