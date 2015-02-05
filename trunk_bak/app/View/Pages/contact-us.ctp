<div class="container">
<div class="contact_bx">
	<span class="contact_us_heading"><?php echo $title_for_layout; ?></span>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Page',array('class'=>"contact_us_frm")); 
	 echo $this->Form->input('first_name',array("maxlength"=>"50",'class'=>"left",'label'=>false,'div'=>array('class'=>'left_bx contact_fld'),'placeholder'=>'First Name')); 
	 echo $this->Form->input('email',array("maxlength"=>"50",'class'=>"left",'label'=>false,'div'=>array('class'=>'left_bx contact_fld'),'placeholder'=>'Email')); 
	echo $this->Form->input('phone',array("maxlength"=>"50",'class'=>"left",'label'=>false,'div'=>array('class'=>'left_bx contact_fld'),'placeholder'=>'Phone')); ?>	
	<span class="left_bx cntct_select"> 
		<?php echo $this->Form->input('type',array('class'=>"",'label'=>false,'div'=>false,"options"=>array(""=>"Select User type","General Inquiry"=>"General Inquiry","Partnerships"=>"Partnerships","Press"=>"Press","Business Development"=>"Business Development","Report a Bug"=>"Report a Bug"))); ?>
	</span>		
	<?php echo $this->Form->input('message',array('rows' => '4', 'cols' => '50','label'=>false,'div'=>array('class'=>'left_bx cntct_txtarea'),'class'=>"left",'placeholder'=>'Message')); 	
	echo $this->Form->submit(__('Submit',true), array('class'=>'cntct_sbmt')); ?>
</div>
</div>
