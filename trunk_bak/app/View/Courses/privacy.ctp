<div class="container">
<?php echo $this->element('coursesLeft');?>
<section class="right-panel">
	<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
	<div class="account-cont">
		<h1>
			Privacy Level<br />
			<span>&nbsp;</span>
		</h1>
			<div class="row">
				<div class="category-box-text">
					<h2>Public Settings</h2>
				</div>
					<?php echo $this->Form->hidden("visibility", array("value"=> $this->data['Course']['visibility']));?>
					<span class="lft">
					<div id="tabs-1" class="tabs-1">
						
							<?php echo $this->Form->input('privacy_type', array('div'=>false,'type'=>'radio','legend'=>false,'options'=>array("3"=>"Course is available for anyone to take on 1337 Institute of Technology."),'value'=>empty($this->data['Course']['privacy_type'])?3:$this->data['Course']['privacy_type'],'id'=>'rdo_1','class'=>'optradio')); ?>
					</div>
					<p class="crs_note">&nbsp;</p>
					</span>
			</div>
			<div class="row">
				<div class="category-box-text">
				<p>&nbsp;</p>
					<h2>Privacy Settings</h2>
					<p>&nbsp;</p>
				</div>
					<span class="lft">
						<div id="tabs-2" class="tabs-2">
							<div class="wrap-1">											
							
							<?php echo $this->Form->input('privacy_type', array('div'=>false,'type'=>'radio','legend'=>false,'options'=>array("1"=>"Invitation Only","2"=>"Password protected"),'value'=>empty($this->data['Course']['privacy_type'])?3:$this->data['Course']['privacy_type'],'id'=>'rdo_1','class'=>'optradio')); ?>
							
							
							<span id="privacy_id">
							<?php echo $this->Form->input('CoursePassword.password', array('label'=>false,'class'=>'access','div'=>false,'type'=>'text','value'=>$password,'placeholder'=>'Choose a Password',(empty($this->data['Course']['privacy_type']) || $this->data['Course']['privacy_type'] == 1)?'disabled':'','maxlength'=>15)); ?>
							</span>
						</div>		
					</div>
					<p class="crs_note">
						&nbsp;
					</p>
					</span>
				</div>							
			</div>
			<p class="txt-center"><input type="submit" class="save_btn" id="save" name="save" value="Save"></p>
	</div>
<?php echo $this->Form->end(); ?>
</section>		
</div>
