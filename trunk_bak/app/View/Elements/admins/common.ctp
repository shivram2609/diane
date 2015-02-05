<!-- bread crumb code below -->
<div class="<?php echo ((!$listflag)?'breadcrume1':'breadcrume'); ?>">
<?php
$header = '';
if(isset($breadcrumb) && !empty($breadcrumb)){
	$i = 0;
	foreach($breadcrumb as $breadCrumbArray){
		if($breadCrumbArray['Breadcrumb']['keylink'] == 1){
			if($i > 0){
				echo " \ ";
			}
			if($breadCrumbArray['Breadcrumb']['keyval'] == 'Home'){
				echo $this->Html->link($breadCrumbArray['Breadcrumb']['keyval'],'/admin/dashboard');
			}else{
				echo $this->Html->link($breadCrumbArray['Breadcrumb']['keyval'],array("controller"=>$breadCrumbArray['Breadcrumb']['keycontroller'],"action"=>$breadCrumbArray['Breadcrumb']['keyaction']));
			}
			$i++;
		}else{
			if($i > 0){
				echo " \ ";
			}
			echo "<span class='light-gray'>".$breadCrumbArray['Breadcrumb']['keyval']."</span> ";
		}
	}
}
?>
</div>
<!-- bread crumb code ends here -->
<?php
if($listflag){
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
<?php echo $this->Session->flash(); ?>
<?php if($buttontitle){
	if($buttontitle != 'no') {
	?>
<div class="rhs_actions right">
	<?php 
	if (!isset($message)) {
		if(isset($frontend) && $frontend) { 
			echo $this->Html->link(__($buttontitle, true), array('action' => $action)); 
		} else {
			echo $this->Html->link(__($buttontitle, true), array('action' => $action)); 
		}
	}
	?> 
</div>
<?php } ?>

<!-- end here -->

<!-- bulk action code below -->
<div id="checkstatus">
<?php 
if (isset($selflag) && !$selflag) {
} else {
if(isset($delete) && $delete == 'no') {
	echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Active"=>'Active',"Inactive"=>'Inactive'),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
} elseif(isset($post) && $post == '1') {
	echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Enable"=>'Approve',"Disable"=>'Disapprove',"Delete"=>'Delete'),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
} elseif(isset($message)) {
	if ($message == 1) {
		echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Trash"=>"Move to Trash"),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
	} elseif($message == 3) {
		echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Read"=>"Restore","Delete"=>"Delete"),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
	}
	else {
	}
} else {
	if(isset($database)){
		echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Delete"=>'Delete'),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
	} else{
		echo $this->Form->input("options",array("options"=>array(""=>'Select Action',"Active"=>'Active',"Delete"=>'Delete',"Inactive"=>'Inactive'),"div"=>false,"label"=>false,"class"=>'options',"style"=>""));
	}
}
if (isset($message) && $message != 1 && $message != 3){
	
} else {
	echo $this->Form->submit("Submit",array("div"=>false,"label"=>false,"id"=>'submitbtn',"class"=>'submit',"style"=>'float: left;margin: 0 0 0 13px;position: absolute;'));
}
}
?>
<label class="error" id="checkerr" style="float: left; margin: -10px 0 0;"></label>
<div class="clear"></div>
</div>
<!-- end here -->
<?php } ?>
<?php
} else {
	?>
	<h2><?php echo __($pageheader);?></h2>
	<div class="clear"></div>
	<?php
}
?>
