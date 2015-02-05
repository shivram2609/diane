<?php
class FckHelper extends Helper {
    var $helpers = Array('Html', 'Js');
    function load($id) {
        $did = '';
        foreach (explode('.', $id) as $v) {
            $did .= ucfirst($v);
        } 
		echo $this->Html->scriptBlock("$(document).ready(function() { CKEDITOR.replace( '".$did."'); });");
	}
	
    function loadlecturecontent($class) {
        echo $this->Html->scriptBlock("$(document).ready(function() { 
			$('.".$class."').each(function(e){
				var id = $(this).attr('id');
				if (CKEDITOR.instances[id]) { CKEDITOR.instances[id].destroy(true); }
			CKEDITOR.replace( id,{toolbar : 'Basic' } )}); });");
	}
	
    function viewlecturecontent($class) {
        echo $this->Html->scriptBlock("$(document).ready(function() { 
			$('.".$class."').each(function(e){
				var id = $(this).attr('id');
				if (CKEDITOR.instances[id]) { CKEDITOR.instances[id].destroy(true);  }
				CKEDITOR.config.removePlugins  = 'elementspath';
				CKEDITOR.config.height  = 455;
				CKEDITOR.config.resize_minWidth  = 1000;
				CKEDITOR.config.resize_maxWidth = 1130;
				CKEDITOR.config.resize_enabled = false;
			CKEDITOR.replace( id,{toolbar : 'Basiclec',readOnly : true } )}); });");
	}
	
    function loadextra($id) {
		$did = '';
        foreach (explode('.', $id) as $v) {
            $did .= ucfirst($v);
        } 
		echo $this->Html->scriptBlock("$(document).ready(function() { CKEDITOR.replace( '".$did."',{toolbar : 'Basic' }); });");
        
	}
	
    function loadextras($class) {
		echo $this->Html->scriptBlock("$(document).ready(function() { 
			$('.".$class."').each(function(e){
				CKEDITOR.config.extraPlugins = 'maxlength';
				var id = $(this).attr('id');
				if (CKEDITOR.instances[id]) {  CKEDITOR.instances[id].destroy(true); }
			CKEDITOR.replace( id,{toolbar : 'Basic' } )
			}); });");
	}
	
	function remove($id) {
		$did = '';
        foreach (explode('.', $id) as $v) {
            $did .= ucfirst($v);
        } 
		echo $this->Html->scriptBlock("$(document).ready(function() { if (CKEDITOR.instances['".$did."']) { CKEDITOR.instances['".$did."'].destroy(true); } });");
	}
}
?>
