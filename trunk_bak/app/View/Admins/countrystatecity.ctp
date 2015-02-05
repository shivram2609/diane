<option value="0"><?php echo $option; ?></option>
<?php
foreach($result as $key => $value){
?>
	<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php	
}
?>
