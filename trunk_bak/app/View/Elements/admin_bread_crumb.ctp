<div class="breadcrume">
<?php

if(isset($breadcrumb) && !empty($breadcrumb)){
	$i = 0;
	foreach($breadCrumb as $breadCrumbArray){
		if($breadCrumbArray['link'] == 1){
			if($i > 0){
				echo " \ ";
			}
			if($breadCrumbArray['key'] == 'Home'){
				echo $this->Html->link($breadCrumbArray['key'],'/dashboard');
			}else{
				echo $this->Html->link($breadCrumbArray['key'],array("controller"=>$breadCrumbArray['controller'],"action"=>$breadCrumbArray['action']));
			}
			$i++;
		}else{
			if($i > 0){
				echo " \ ";
			}
			echo "<span class='light-gray'>".$breadCrumbArray['key']."</span> ";
		}
	}
}
?>
</div>
