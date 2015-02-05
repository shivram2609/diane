<div class="container">
	<?php echo $this->element('coursesLeft'); ?>
	<section class="right-panel">
		<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
		<div class="account-cont">
		<h1>Price</h1>
    		<div class="row">
				<div class="category-box-text3">
					<h2>Free</h2>
				</div>
					<?php echo $this->Form->hidden('pricetype',array("value"=>$this->data['Course']['pricetype'])); ?>
					<div class="lft">
						<div class="price-rt"> <input type="radio" name="pricetypeval"  id="Free" <?php echo ($this->data['Course']['pricetype'] == "Free")?"checked":"" ?> /> &nbsp; Your course will be free.</div>
					</div>
			</div>
			<div class="row">
				<div class="category-box-text3">
				
					<h2>Paid</h2>
				
				</div>
					<div class="lft">
						<div class="price-rt price-rt-no">
							<?php if(!empty($paypal)) { ?>
								<input type="radio" id="Paid" name="pricetypeval" <?php echo ($this->data['Course']['pricetype'] == "Paid")?"checked":"" ?> /> &nbsp; $ &nbsp; <?php echo $this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"label"=>false,"value"=>$this->data['Course']['price'])); ?>
							<?php } else { ?>
								<input type="radio" id="Paids" name="pricetypeval"> &nbsp; $ &nbsp;<?php echo $this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"label"=>false,"value"=>$this->data['Course']['price'],"disabled")); ?>
							<?php } ?>
							<div class="error-message"></div>
					    </div>
					</div>
			</div>	
		</div>
		<p class="sml-txt1">
		<?php if(!empty($paypal)) { ?>
			
		<?php } else { ?>
			Your payment method has not been verified, Please <a href="<?php echo $this->Html->url('/paypal-account'); ?>" target="_blank">Click here</a> to enter your paypal email before adding a paid course.
		<?php } ?></p>
		<p class="txt-center"><?php echo $this->Form->submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn','id'=>'savePrice')); ?>
		<?php echo $this->Form->end(); ?></p>
		
		
		<!--<div class="price-coupons price">
			<?php /* echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
			<div class="tabs_outer">
			<br />
				<div id="tabs" class="tabs-pop">
					<ul>
						<li id="Free" class="priceSetting"><a href="#tabs-1">Free</a></li>
						<?php if(!empty($paypal)) { ?>
							<li id="Paid" class="priceSetting"><a href="#tabs-2">Paid</a></li>
						<?php } else { ?>
							<li id="Paids" class="priceSetting"><a href="#tabs-2">Paid</a></li>
						<?php } ?>
					</ul>
					<?php echo $this->Form->hidden('pricetype',array("value"=>$this->data['Course']['pricetype'])); ?>
					<div id="tabs-1" class="tabs-1">
						<img src="<?php echo $this->webroot;?>img/upper_arrow.png" alt="" />
						<div class="wrap-1">											
							<p>Your course will be free and available on IOT 1337.</p>
						</div>								
					</div>
					<div id="tabs-2" class="tabs-2">
						<img src="<?php echo $this->webroot;?>img/upper_arrow.png" alt="" />
						<p>
							<!--<input type="text" size="20" class="access" id="p" name="" placeholder="$ Set a Price" />-->
							<span class="pro_fld" id="price_cont" style="display:none"><?php echo $this->data['Course']['pricetype'];?></span>
							<?php 
							
							if($this->data['Course']['pricetype'] == "Paid" || empty($paypal) ){
								echo '$'.$this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"label"=>false,"value"=>$this->data['Course']['price']));
							} else{
								echo '$'.$this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"placeholder"=>"$ Set a Price","disabled"=>true,"label"=>false));
							}
							?>
							
						</p>
						<div class="error-message"></div>
					</div>
					<p class="crs_note">
						<?php if(!empty($paypal)) { ?>
							TIP: Your course should be priced: Fairly based on the amount and quality of course content. Competitively based on other courses found on IOT 1337 and other e-Learning sites.
						<?php } else { ?>
							Your payment method has not been verified, Please <!--<a href="<?php //echo $this->Html->url('/paypal-account'); ?>" target="_blank"> --><a href="javascript:void(0);" class="addpaypal">Click here</a> to enter your paypal email before adding a paid course.
						<?php } ?>
					</p>
				</div>
				<div id="paypal" class="hide">
					<?php echo $this->Form->input("Userdetail.paypalaccount",array("type"=>"text","label"=>"PayPal Email","div"=>false,"maxlength"=>"100","disabled","class"=>"text")); ?>
					<br/>
					<a href="javascript:void(0);" id="cancelpaypal" title="Cancel">Cancel</a>
				</div>							
			</div>
			<?php /*<p class="txt-center"><input type="button" value="Cancel" class='save_btn' id='cancelprice'>*/?><?php /* echo $this->Form->submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn','id'=>'savePrice')); ?></p> 
		<?php echo $this->Form->end();*/ ?>
		<div class="blackOpcty_quote" style="display:none"></div>
	</div> -->
		
		
	</section>
</div>
 
