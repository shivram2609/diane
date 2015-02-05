<?php
if ($this->Session->read("Auth.User.id")) {
$url = SITE_LINK."profile/".$this->Session->read("Auth.User.Userdetail.user_id")."/".$this->Common->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")); 
?>
<script type="text/javascript">
window.opener.parent.location = '<?php echo $url; ?>';
//window.opener.parent.reload();
</script>
<?php } else { ?>
<script type="text/javascript">
window.close();
window.parent.location.href = '<?php echo SITE_LINK; ?>';
//opener.open('<?php echo SITE_LINK; ?>');
</script>
<?php } ?>
<?php echo $this->Session->flash(); ?>
<?php // echo "You are logged in"; ?>
<script type="text/javascript">
window.close();
</script>

