<?php
class ColorboxHelper extends Helper {
	var $helpers = array("Html");
	function openpop($link){
		$code = "$(document).ready(function() { $.fn.colorbox({href:'".$link."', open:true}); });";
		echo $this->Html->scriptBlock($code);
	}
	
	function openexternalpopup ($id,$height="50%",$width="50%") {
		$code = '$(document).ready(function(){
			$("#'.$id.'").click(function(e){
				$(this).colorbox({iframe:true, fastIframe:false, width:"'.$width.'", height:"'.$height.'", transition:"fade", scrolling   : true});
				e.preventDefault();
			});
		});';
		echo $this->Html->scriptBlock($code);
	}
	
	function openexternalpopups ($id,$height="50%",$width="50%") {
		$code = '$(document).ready(function(){
			$(".'.$id.'").click(function(e){
				$(this).colorbox({iframe:true, fastIframe:false, width:"'.$width.'", height:"'.$height.'", transition:"fade", scrolling   : true});
				e.preventDefault();
			});
		});';
		echo $this->Html->scriptBlock($code);
	}
	
	function openexternalpopuponload ($url,$height="50%",$width="50%") {
		$code = '$(document).ready(function(){
			$.colorbox({href:"'.$url.'",iframe:true, fastIframe:false, width:"'.$width.'", height:"'.$height.'", transition:"fade", scrolling   : true});
			});';
		echo $this->Html->scriptBlock($code);
	}
	
	function openinlinepop($class,$height=200,$width=200) {
		$code ='$(document).ready(function(){ $(".'.$class.'").colorbox({inline:true, height:"'.$height.'", width:"'.$width.'"}); });';
		echo $this->Html->scriptBlock($code);
	}
}
?>
