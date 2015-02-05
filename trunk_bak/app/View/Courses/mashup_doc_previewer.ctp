<script type="text/javascript">
		var BASE_URL = "<?php echo SITE_LINK; ?>";
</script>
<script type="text/javascript" >
 function getDocumentInfo(){		     
	 var setup= {
		doc: "<?php echo $mashupDoc; ?>",
	}
	return setup;
 }    
</script>
		    
        <script type="text/javascript">
            var swfVersionStr2 = "10.0.0";
            var xiSwfUrlStr2 = "";
            var flashvars2 = {};
            var params2 = {};
            params2.quality = "high";
            params2.bgcolor = "#ffffff";
            params2.allowscriptaccess = "sameDomain";
            params2.allowfullscreen = "true";
            var attributes2 = {};
            attributes2.id = "DocPreview";
            attributes2.name = "DocPreview";
            attributes2.align = "middle";
            swfobject.embedSWF(
                BASE_URL+"files/bin-debug/DocPreview.swf", "<?php echo "flashDocPreviewer_{$uniqueId}"; ?>", 
                "450", "350", 
                swfVersionStr2, xiSwfUrlStr2, 
                flashvars2, params2, attributes2);
			<!-- JavaScript enabled so display the flashContent div in case it is not replaced with a swf object. -->
			swfobject.createCSS("<?php echo "#flashDocPreviewer_{$uniqueId}"; ?>", "display:block;text-align:left;");
        </script>
        <!-- SWFObject's dynamic embed method replaces this alternative HTML content with Flash content when enough 
			 JavaScript and Flash plug-in support is available. The div is initially hidden so that it doesn't show
			 when JavaScript is disabled.
		-->
        <div id="<?php echo "flashDocPreviewer_{$uniqueId}"; ?>"></div>
