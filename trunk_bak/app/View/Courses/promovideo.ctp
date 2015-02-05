<div class="container">
	<?php echo $this->element('coursesLeft');?>
	<section class="right-panel">
		<h1>Promo Video</h1>
		
		<div class="image-outer1">
			<div class="category-box-text"><h2>Video Preview</h2>
				<p>Video should be at a minimum of 817x451 and 1-2 minutes in length.</p>
			</div>	
			<div class="rt-txt"><p class="txt-center"></p>
				<?php echo $this->Form->create('Course',array("type"=>"file","class"=>"profile_bx")); ?>
			<div class="input_full blog_select upload_default_theme">
				<h3>Add/Change Video:</h3>
				<div class="input file">
					<div class="uploader manualfile" id="uniform-PhotoFile" style="height:60px;">
						<?php echo $this->Form->input('Course.promovideo',array("class"=>"TxtFld upload_default","type"=>"file","div"=>false,"label"=>false,"value"=>"")); ?>
						<span class="filename" style="-moz-user-select: none;">Video files must be .mp4, .mov, .wmv, .flv, .3gp, .quicktime, .avi, .mpeg, .wav</span>
						<span class="action" style="-moz-user-select: none;">Browse</span>
						<span style="display: inline-table;float: left;">OR <a href="javascript:void(0);" class="importyoutube">Import from Youtube / Vimeo</a></span>
					</div>
					<div class="youtubefile hide" id="" style="height:60px;">
						<?php echo $this->Form->input('Course.promovideo1',array("class"=>"TxtFld upload_default","type"=>"text","disabled"=>true,"div"=>false,"label"=>false,"value"=>"")); ?><a href="javascript:void(0);" id="cancleyoutube">Cancel</a>
					</div>
					<p><?php echo $this->Form->Submit("Upload Video File",array('label'=>false,'div'=>false,'class'=>'action')); ?></p>
				</div>	
		   </div>
		   
			<?php echo $this->Form->end();?>
			</div>
			<div class="clear-fix"></div>
			<?php if((strpos(strtolower($this->data['Course']['promovideo']), "vimeo.com"))) { 
				$data = $this->Common->video_info($this->data['Course']['promovideo']);
				//pr($data);
				?>
				<div class="video-frame1">
				<iframe src="http://player.vimeo.com/video/<?php echo $data['video_id']; ?>" width="675px" height="270px" frameborder="2" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
			<?php } elseif((strpos(strtolower($this->data['Course']['promovideo']), "youtube.com"))) { 
				$data = $this->Common->video_info($this->data['Course']['promovideo']);
				//pr($data);
				?>
				<div class="video-frame1">
				<iframe width="675px" height="270px" src="http://www.youtube.com/embed/<?php echo $data['video_id']; ?>" frameborder="2" allowfullscreen></iframe>
				</div>
			<?php } else { ?>
			<?php echo $this->Html->script("assets/jwplayer"); ?>
			<script type="text/javascript">
				var primaryCookie = 'html5';
				var skinURL = "<?php echo SITE_LINK; ?>js/assets/skins/six/six.xml";
			</script>
			
			<div class="video-frame1">
				<?php if(!empty($this->data['Course']['promovideo'])){ ?>
				<div id="video-frame" class="video-frame1">
					<?php echo $this->data['Course']['promovideo']; ?>
				</div>
				<?php } else{
						echo $this->Html->image('/img/promo-video-dummy.png');	
				}?>
			</div>
				<script type="text/javascript">
					jwplayer("video-frame").setup({
						file: '<?php echo SITE_LINK.$this->data['Course']['promovideo']; ?>',
						image: '<?php echo SITE_LINK.$this->data['Course']['promovideo'].".jpg"; ?>',
						primary: primaryCookie,
						skin: skinURL,
						width: 675
					});
				</script>
				
			<?php } ?>
			</div>
			
		
	</section>
</div>

