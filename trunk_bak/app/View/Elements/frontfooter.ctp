<footer>
	<div class="footer-cont">
	<div class="social_media-sml shere-footer">Share with:<ul class="right" style="width:auto;" >
				<!--li><a class='fb' href="javascript:void(0);">Facebook</a></li>
				<li><a class='twitter' href="javascript:void(0);">Twitter</a></li>
				<li><a class='linkedin' href="javascript:void(0);">Linkedin</a></li-->
				<li><a class='fb' href="javascript:void(0);"><span class='st_facebook_large' displayText='Facebook'></span></a></li>
				<li><a class='twitter' href="javascript:void(0);"><span class='st_twitter_large' displayText='Tweet'></span></a></li>
				<li><a class='gplus' href="javascript:void(0);"><span class='st_googleplus_large' displayText='Google +'></span></a></li>
				</ul>
				</div><br>
		<div class="follow-us">
		
				Connect with us:<br />
			<!--ul class="social_media">
				<li><span class='st_facebook_large fb' displayText='Facebook'></span></li>
				<li><span class='st_twitter_large twitter' displayText='Tweet'></span></li>
				<li><span class='st_linkedin_large linkedin' displayText='LinkedIn'></span></li>
				<li><span class='st_googleplus_large gplus' displayText='Google +'></span></li>
				<li><span class='st_pinterest_large pinterest' displayText='Pinterest'></span></li>
				
			</ul-->
			<ul class="social_media">
				<li><a class="fb" href="http://www.facebook.com/1337institute" target="_blank" title="Facebook"></a></li>
				<li><a class="twitter" href="http://twitter.com/1337institute" target="_blank" title="Twitter"></a></li>
				<li><a class="linkedin" href="http://www.linkedin.com/company/1337-institute-of-technology" target="_blank" title="Linked In"></a></li>
				<li><a class="gplus" href="https://plus.google.com/+1337institute/" target="_blank" title="Google Plus"></a></li>
				<li><a class="pinterest" href="http://www.pinterest.com/1337IOT/" target="_blank" title="Pinterest"></a></li>
				<li><a class="youtube" href="http://www.youtube.com/user/1337Institute" target="_blank" title="Youtube"></a></li>
				<li>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="ELJWHG93NC2TG">
						<input type="submit" class="donate no-uniform"  title="Donate" value="Donate"></li>
					</form>
				</li>
			</ul>
		</div>
		<ul>
			<?php foreach($pages as $page): ?>
				<li><a href="<?php echo $this->Html->url("/st/".$page['Cmspages']['seourl']); ?>" title="<?php echo $page['Cmspages']['name'];?>"><?php echo $page['Cmspages']['name'];?></a></li>
			<?php endforeach;?>
			<li><a href="<?php echo $this->Html->url("/contact-us"); ?>" title="Contact Us">Contact Us</a></li>
			<li><a href="<?php echo $this->Html->url("/support"); ?>" title="support">Support</a></li>
			<li><a href="<?php echo $this->Html->url("/blog"); ?>" title="Blog">Blog</a></li>
			<li><a href="<?php echo $this->Html->url("/site-map"); ?>" title="Site Map">Site Map</a></li>
		</ul>
<p>All content &copy; 2013 by 1337 Institute of Technology. All rights reserved.</p>
		<!-- <div class="help-icon"><a href="javascript:void(0);" Title="Help"></a></div> -->
	</div>
	
</footer>
<?php if(strpos(SITE_LINK,'1337institute')) { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46302279-1', '1337institute.com');
  ga('send', 'pageview');

</script>
<?php } ?>
<?php echo $this->Html->script(array('jquery.validate','jquery.uniform','validationmessages','jquery.flexslider','jquery.form','functionality','charCount')); ?>
<script type="text/javascript">
	$(document).ready(function(){
    $(function(){
      //SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
});
  </script>
<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if(!$this->Session->read("Auth.User.id") ) { ?>
	<?php echo $this->Html->script("jquery.colorbox"); ?>
	<?php echo $this->Html->css("colorbox"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("signin","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("signup","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse1","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse12","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse13","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("createcourse14","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopup ("mycourse","600","540px"); ?>
	<?php echo $this->Colorbox->openexternalpopups("wishlist","600","540px"); ?>
<?php } ?>



<?php
/* end of code to include colorbox and jquery.ui for campaign add page only */
?>
<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if($this->params['controller'] == "users" && ($this->params['action'] == "confirmregisteration") ) { ?>
	<?php $url = SITE_LINK."login"; ?>
	<?php echo $this->Colorbox->openexternalpopup ("signup","70%","60%"); ?>
<?php } ?>
<?php
/* end of code to include colorbox and jquery.ui for campaign add page only */
?>
<?php
/* code to include colorbox and jquery.ui for campaign add page only */
?>
<?php if($this->params['controller'] == "userdetails" && ($this->params['action'] == "edit_profile") ) { ?>
	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
	<?php //echo $this->Fck->remove('addtext');  ?>
	<?php //echo $this->Fck->loadextra('addtext');  ?>
	
	<?php echo $this->Fck->loadextra('UserdetailBiography');  ?>
<?php } ?>

<?php if($this->params['action'] == "editcurriculum") { ?>
<?php //echo $this->Html->script('ckeditor/ckeditor'); ?>
	<?php //echo $this->Fck->remove('addtext');  ?>
	<?php // echo $this->Fck->loadextra('addtext');  ?>
<?php } ?>

<?php if($this->params['controller'] == "courses" && ($this->params['action'] == "details") ) { ?>
	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
	<?php echo $this->Fck->loadextra('CourseSummary');  ?>
	<?php echo $this->Html->css(array("tooltip"),NULL,array("media"=>"screen")); ?>
	<?php echo $this->Html->script('tooltip'); ?>
<?php } ?>

<?php
/* end of code to include colorbox and jquery.ui for campaign add page only */
?>



<?php if($this->params['controller'] == 'courses') { 
		echo $this->element('help-popup', array($this->data));
		echo $this->Html->script(array('jquery.ui','jquery.ui.tabs')); 

	}
	if(($this->params['controller'] == 'courses') && ($this->params['action'] == 'search')){ ?>
	<script>
		$(document).ready(function(){
				$("input, select").not('.no-uniform').uniform();
		});
		</script>
<?php
	}
?>
<?php /* End Help pop-up for Course Pages */ ?>

<?php if(($this->params['controller'] == "courses" && $this->params['action'] == "view")) { ?>
<script type="text/javascript">
			$(document).ready(function(){
				$(function() {
					var offset = $(".social-share").offset();
					var topPadding = 15;
					$(window).scroll(function() {
						if ($(window).scrollTop() > offset.top) {
							$(".social-share").stop().animate({
								marginTop: $(window).scrollTop() - offset.top + topPadding
							});
						} else {
							$(".social-share").stop().animate({
								marginTop: 0
							});
						};
					});
				});
			});
		</script>
	<?php if(($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") != $coursedetail['Course']['user_id']) && !isset($usercourse)) { ?>
		
		<?php echo $this->Html->script("jquery.colorbox"); ?>
		<?php echo $this->Html->css("colorbox"); ?>
		<?php //echo $this->Html->css("extra"); ?>
		<?php echo $this->Colorbox->openinlinepop("inline","302px","50%"); ?>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "ur-72767fa4-5d89-ab35-fa2f-6c8ef782411", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
	<?php } else { ?>
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "ur-9ee4ed40-2bde-e6cf-66d9-51df2b5433f2", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
	<?php } ?>
	<style>
@media only screen and (max-width:600px){
#colorbox{position: fixed !important; left:5% !important; top:10% !important; margin-bottom:10% !important;}
}
</style>
<?php } ?>
<?php if($this->params['action'] == 'viewlecture') { ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-634adfcd-165d-eda2-a225-200fe9605e20", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php } ?>
<?php if(($this->params['controller'] == "courses") && (($this->params['action'] == "gettingstarted") || ($this->params['action'] == "price"))) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
	});
	</script>
<?php } ?>
<?php if ($this->Session->read("FB.Me.id") || $this->params['action'] == 'login' || $this->params['action'] == 'signup' || ($this->params['controller'] == 'courses' && $this->params['action'] == 'successfullyenrolled' ) ) { ?>
<?php echo $this->Facebook->init(); ?> 
<?php } ?>
<?php if($this->params['action'] == 'viewprofile') { ?>
<?php /* Script for social links on View Profile Page */ ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "5b0937f6-9650-4e52-b372-4faedfc33ec3", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php /* Script for getting started page */ ?>
<?php } ?>
<?php // if($this->params['controller'] == 'pages' && $this->params['action'] == 'index') { ?>
<?php /* Script for social links on View Profile Page */ ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-7833f0fa-b81e-3529-adb1-abda2c017291", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php /* Script for getting started page */ ?>
<?php // } ?>
