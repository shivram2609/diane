<?php
	$url= SITE_LINK;
?>
<script type="text/javascript">
setInterval(function(){location.href= "<?php echo $url; ?>";},300);
</script>
<?php
if($this->Session->read('Auth.User')){
}else{
echo "javascripton is disabled on your browser pls <a href='".SITE_LINK."'>click here</a> to exit.";
} ?>
