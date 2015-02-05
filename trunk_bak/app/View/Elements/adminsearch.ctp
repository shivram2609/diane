<div class="search-box">
	<?php echo $this->Form->input("searchval",array("type"=>'text',"placeholder"=>$place,"div"=>false,"label"=>false)); ?>
	<?php echo $this->Form->submit("Search",array("label"=>false,"div"=>false,"class"=>'invite-button nomargin submitsearch',"id"=>'submitbtn',"attr"=>'search'));
	if($flag){
	?>
	<br/><span style="font-size:11px;"><i>date format : yyyy-mm-dd</i><span>
	<?php } ?>
</div>
