<?php
	$url= SITE_LINK."admin";
?>
<script type="text/javascript">
setInterval(function(){location.href= "<?php echo $url; ?>";},300);
</script>
<?php
if($this->Session->read('admin')){
}else{
echo "javascripton is disabled on your browser pls <a href='/checkrope/admin'>click here</a> to exit.";
} ?>
