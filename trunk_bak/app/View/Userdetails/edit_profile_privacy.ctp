<div class="container">
	<?php echo $this->Session->flash(); ?>
	<div class="clear-fix">&nbsp;</div>
	<?php echo $this->element('userdetailsleft');?>
	<section class="right-panel">
		<div class="privacy">
			<h1>
				Privacy Settings<br />
				<span>&nbsp;</span>
			</h1>
			<?php echo $this->Form->create('Userdetail'); ?>
			<div class="account-cont">
			
				<div class="row">
					<?php echo $this->Form->create('Userdetail'); ?>
					<div class="category-box-text2">
						<h2>Privacy Settings</h2>
						</div>
						<span class="lft border-pry">
							
							
							
							<?php 	
								if(isset($this->data['Userdetail']['privacy'])){
									$privacySetting = unserialize($this->data['Userdetail']['privacy']);
									$showInSearch = $privacySetting['Show Profile in Search Engines'];
									$showCoursesInProfile = $privacySetting['Show Courses in Profile'];
									$useTransactionInfo = $privacySetting['make profile private'];
								} else{
									$showInSearch = 0;
									$showCoursesInProfile = 0;
									$useTransactionInfo = 0;
								}
								?>
								<p> Make my profile private.
								<?php 
								if($useTransactionInfo == 1): ?>
									<input type="image" src="<?php echo $this->webroot;?>img/on-btn.png" value="1"  class="setting"  /></p>
									<?php echo $this->Form->hidden('make profile private', array('value'=>1));?>
								<?php else: ?>
									<input type="image" src="<?php echo $this->webroot;?>img/off-btn.png" value="0"  class="setting"  /></p>
									<?php echo $this->Form->hidden('make profile private', array('value'=>0));?>
								<?php endif;?>
								
								<p class="bdr-top">Show my profile on search engines.
								<?php if($showInSearch == 1): ?>
									<input type="image" src="<?php echo $this->webroot;?>img/on-btn.png" value="1"  class="setting"  /></p>
									<?php echo $this->Form->hidden('Show Profile in Search Engines', array('value'=>1));?>
								<?php else: ?>
									<input type="image" src="<?php echo $this->webroot;?>img/off-btn.png" value="0"  class="setting"  /></p>
									<?php echo $this->Form->hidden('Show Profile in Search Engines', array('value'=>0));?>
								<?php endif;?>
								<p class="bdr-top">Show courses I am taking on my profile page. 
								
								<?php 
								if($showCoursesInProfile == 1): ?>
									<input type="image" src="<?php echo $this->webroot;?>img/on-btn.png" value="1"  class="setting"  /></p>
									<?php echo $this->Form->hidden('Show Courses in Profile', array('value'=>1));?>
								<?php else: ?>
									<input type="image" src="<?php echo $this->webroot;?>img/off-btn.png" value="0"  class="setting"  /></p>
									<?php echo $this->Form->hidden('Show Courses in Profile', array('value'=>0));?>
								<?php endif;?>
								
								</span>								
									

					</div>							
				</div>
				<!-- <p class="txt-center"><input type="submit" class="save_btn" id="save" name="save" value="Save"></p>-->
			<p class="txt-center"><?php echo $this->Form->Submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn')); ?></p>
		</div>
	</section>
</div>
