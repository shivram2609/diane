<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'Configurations',"buttontitle"=>'Add State',"listflag"=>false)); ?>
<div class="blogs form">
<?php 
echo $this->Session->flash();
echo $this->Form->create("Configuration", array("type"=>"file"));
$siteUrl = Router::url('/', true);
?>
<fieldset>
 		<legend><?php __('Configuration'); ?></legend>
<?php
$i = 1;
foreach ($configurations as $config) {
	//pr($config);
	if(strpos($config['Configuration']['default_header'],'HOMEPAGE_BANNER') !== FALSE ) {
		if ( strpos($config['Configuration']['default_header'],'HOMEPAGE_BANNER_IMAGE_TEXT') !== FALSE ) {
			echo $this->Form->input($config['Configuration']['id'],array("type"=>"textarea","label"=>$config['Configuration']['heading'],"value"=>$config['Configuration']['value']));
			unset($config['Configuration']['id']);
		} 
		if ( strpos($config['Configuration']['default_header'],'HOMEPAGE_BANNER_IMAGE_LINK') !== FALSE ) {
			echo $this->Form->input($config['Configuration']['id'],array("type"=>"text","label"=>$config['Configuration']['heading'],"value"=>$config['Configuration']['value']));
			unset($config['Configuration']['id']);
		} 
		if(isset($config['Configuration']['id'])) {
			echo $this->Form->input($config['Configuration']['id'],array("type"=>'file','label'=>$config['Configuration']['heading']));
			echo $this->Html->image($siteUrl.ltrim($config['Configuration']['value'],"/"), array("width"=>"1230px", "height"=>"300px"));
		}
		$i++;
	} 
	
}
foreach ($configurations as $config) {
	if($config['Configuration']['default_header'] == 'API_MODE' && strpos($config['Configuration']['default_header'],'HOMEPAGE_BANNER') === FALSE) {
		echo $this->Form->input($config['Configuration']['id'],array("options"=>array("sandbox"=>"sandbox","live"=>"live"),"value"=>$config['Configuration']['value'],'label'=>$config['Configuration']['heading']));
	}else if(strpos($config['Configuration']['default_header'],'HOMEPAGE_BANNER') === FALSE ){
		echo $this->Form->input($config['Configuration']['id'],array("type"=>'text',"value"=>$config['Configuration']['value'],'label'=>$config['Configuration']['heading']));
	}
}
?></fieldset><?php
echo $this->Form->Submit("Submit");
echo $this->Form->end();
?>
</div>
