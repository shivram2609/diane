<div class="container">
	<?php echo $this->Session->flash(); ?>
<!--====Payment Left Panel Start====-->
	<div class="payment-lt">
		<div class="step1">
			<span class="steps-nbr">1</span>
			<span class="course-pric">
				Course Price <br>
				<?php //pr($course); ?>
				<span class="prc">$<?php echo $course['Course']['price']; ?></span>
			</span>
			<p><a href="javascript:void(0);" title="<?php echo $course['Course']['title']; ?>"><?php echo $course['Course']['title']; ?></a></p>
		</div>
		<div class="step2">
			<span class="steps-nbr">2</span>
			<?php echo $this->Form->create('Course',array('class'=>"frm")); ?>
			<p>Pay with your own credit card on our secure page:</p>
			<label>First Name:</label>
			<?php echo $this->Form->input('first_name',array("maxlength"=>"50",'label'=>false,'div'=>false,'placeholder'=>'First Name')); ?>
			<label>Last Name:</label>
			<?php echo $this->Form->input('last_name',array("maxlength"=>"50",'label'=>false,'div'=>false,'placeholder'=>'Last Name')); ?>
			<label>Card Type: </label>
			<?php echo $this->Form->input("card_type",array("options"=>array(""=>"Select Card Type","American Express"=>"American Express","Discover"=>"Discover","Visa"=>"Visa"),"label"=>false,'div'=>false)); ?>
			<label>Card Number: </label>
			<?php echo $this->Form->input("card_number",array("type"=>"text","maxlength"=>16,"label"=>false,'label'=>false,'div'=>false,'placeholder'=>'Card Number')); ?>
			<div class="clear-fix"></div>
			<span class="lt-side-frm">
				<label>Expiration Date:</label>
				<?php 
				echo $this->Form->input("exp_month",array("options"=>array(""=>"Months",$montharr),"label"=>false,'div'=>false));
				echo $this->Form->input("exp_year",array("options"=>array(""=>"Years",$yeararr),"label"=>false,'div'=>false)); ?> 
			</span>
			<span class="rt-side-frm">
				<label>Security Code:</label>
				<?php
				echo $this->Form->input('cvv',array("type"=>"password","maxlength"=>"3",'label'=>false,'div'=>false,'placeholder'=>'Security Code'));
				?>
			</span>
			<label>Address Line 1:</label>
			<?php echo $this->Form->input('customer_address1',array("maxlength"=>"100",'label'=>false,'div'=>false,'placeholder'=>'Address Line 1')); ?>
			<label>Address Line 2:</label>
			<?php echo $this->Form->input('customer_address2',array("maxlength"=>"100",'label'=>false,'div'=>false,'placeholder'=>'Address Line 2')); ?>
			<span class="lt-side-frm">
				<label>City:</label>
				 <?php echo $this->Form->input('customer_city',array("maxlength"=>"100",'label'=>false,'div'=>false,'placeholder'=>'City')); ?>
				<label>State/Province/Region:</label>
				 <?php echo $this->Form->input('customer_state',array("maxlength"=>"100",'label'=>false,'div'=>false,'placeholder'=>'State')); ?>
			</span>
			<span class="rt-side-frm">
				<label>Zip Code:</label>
				<?php echo $this->Form->input('customer_zip',array('type'=>"text",'label'=>false,'div'=>false,'placeholder'=>'zip')); ?>
				<label>Country:</label>
				<?php echo $this->Form->input("customer_country",array("options"=>array(""=>"Select Country",$countryarr),"label"=>false,"class"=>"lrg",'div'=>false)); ?>
			</span>
			
			<p class="txt-center"><br><?php echo $this->Form->submit(__('Complete Purchase',true)); ?></p>
			<p class="note">By clicking "Complete purchase", I have read and agree to the <a href="javascript:void(0);" title="Terms and Conditions">Terms and Conditions</a> and <a href="javascript:void(0);" title="Privacy Policy">Privacy Policy</a>. <br>Note: When you click "Complete purchase", you will be billed immediately.</p>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
<!--====Payment Left Panel end====-->
<!--====Payment Right Panel Start====-->
	<div class="payment-rt">
		<h3>WHAT YOU GET :</h3>
		<ul>
			<li>Lifetime access to the online course "<?php echo $course['Course']['title']; ?>" complete with all lectures.</li>
			<li>On demand access to complete the course.</li>
			<!--li>An interactive discussion board where students can connect with the instructor & fellow students.</li-->
		</ul>
		<span class="pay-norton-secur" >THIS PAGE IS SECURE:<br>
		<!--img src="<?php //echo $this->webroot; ?>img/norton-security.png" width="143" height="158" alt="Norton Security" /-->
		<img src="<?php echo $this->webroot; ?>img/pay-pal-security.png" width="117" height="158" alt="PayPal Security" />
		</span>
	</div>
<!--====Payment Right Panel End====-->		
</div>
