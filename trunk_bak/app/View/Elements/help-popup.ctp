<?php if($this->params['controller'] == 'courses' && $this->params['action'] == 'basic') { ?>
<!-- Basic Help Poup-->
<div class="live-sess-popup" style="display:none">
 <h2>More about title <span class="close-icon"><a href="javascript:void(0);" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup">
	<div class="cont">
	<p>The title of your course is key to your success as an instructor on 1337IOT so make it good!</p>
	<p>Titles should be 3 things:</p>
		<ul>
			<li>Short</li>
			<li>Descriptive</li>
			<li>Punchy</li>
		</ul>
	</div>
	<div class="cont">
		<h3>Short and Sweet</h3>
		<p>When we talk "short", this doesn't mean 1-3 words. It means that your title should be concise and fall between 25 - 50 characters.</p>
		<p>Let's look at a comparison:<br />
			<span>	"Learning Python Programming in Just 5 Easy Steps and TWO WEEKS!"<br />
			Or:<br />
			"Learn Python in 5 Easy Steps"<br />
			Both are descriptive, but the latter is more to-the-point and easier to read.	
			</span>
		Both are descriptive, but the latter is more to-the-point and easier to read.
		</p>
	</div>	
 </div>
</div> 
<div class="blackOpcty_quote" style="display:none"></div>
<!--Help Poup-->	  

<!-- Basic Help Poup-->
<div class="subtitleHelp" style="display:none">
 <h2>More about Subtitle <span class="close-icon"><a href="javascript:void(0);" id="closePop" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup">
	<div class="cont">
	<p>A subtitle serves to reinforce a title with more detail without being redundant. In many ways, the principles behind creating a successful subtitle are the same for titles. If you haven't already, read about titles. A subtitle should not only be descriptive, but it helps support the title by telling students what they will learn if they take the course. </p>
	<p>Here's a couple examples: </p>
		<ul>
			<li>An A-Z guide in creating amazing images and clips using the newest version of the industry's preferred software, Photoshop CS6.</li>
			<li>Go from vine to table with confidence with the help of a wine expert.</li>
		</ul>
	</div>
	<div class="cont">
		<h3>The Takeaway</h3>
		<p>When we talk "short", this doesn't mean 1-3 words. It means that your title should be concise and fall between 25 - 50 characters.</p>
		<p>Here are some guidelines to follow when you’re creating subtitles:</p>
			<ul>
				<li>Make sure your subtitle is a full sentence (or a set of well-planned fragments):</li>
				<ul>
					<li><b>Good</b>: "Learn the basics of freelancing without ever leaving the house."</li>
					<li><b>Not-so-good</b>: "Basic freelancing tips."</li>
				</ul>
				<li>Exclamations are okay, but don't go overboard!</li>
				<li>Turn off your CAPS lock. Unless you’re spelling an acronym or abbreviation.</li>
				<li>Try to include words and phrases like:</li>
				<ul>
					<li>How to</li>
					<li>Learn</li>
					<li>Improve [ -- ] Skills</li>
					<li>Easy (or simple)</li>
				</ul>
				<li>Use verbs as action words speak louder.</li>
				<li>
				Be concrete - use language that communicates the goals of your course and puts an image of success
				in the heads of your potential students. </li>
			</ul>
	</div>	
 </div>
</div> 
<div class="blackOpcty_quote" style="display:none" id="subTitleoverlay"></div>
<!--Help Poup-->	  

<?php } elseif($this->params['controller'] == 'courses' && $this->params['action'] == 'details') { ?>

<!-- Basic Help Poup-->
<div class="live-sess-popup" style="display:none">
 <h2>More About Details <span class="close-icon"><a href="javascript:void(0);" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup">
	<div class="cont">
		<h3>Course Summary</h3>
		<p>Give an overview of your course and consider:</p>
		<ul>
			<li>What is the course about?</li>
			<li>What kind of materials are included?</li>
			<li>How long will the course take to complete?</li>
			<li>How is the course structured?</li>
			<li>Why take this course?</li>
		</ul>
	</div>
	

 </div>
</div> 
<div class="blackOpcty_quote" style="display:none"></div>
<!--Help Poup-->	 


<!--===Details tooltip Popup 1===-->
<div style="display:none;">
	<div id="tool_tip1">
	   <p>Give an overview of your course and consider:</p>
		<ul>
		<li>What is the course about?</li>
		<li>What kind of materials are included?</li>
		<li>How long will the course take to complete?</li>
		<li>How is the course structured?</li>
		<li>Why take this course?</li>
		</ul>
	</div>
</div>
 <!--===tooltip Popup 2===-->	
 <div style="display:none;">
	<div id="tool_tip2">
	   <p>Course Goal:</p>
		<ul>
		<li>By the end of the course, you will be able to do X.</li>
		</ul>
		<p>Course Objectives:</p>
		<ul>
		<li>In this course, you will learn A, B, and C.</li>
		</ul> 
		
	</div>
</div>
 <!--===tooltip Popup 3===-->
 <div style="display:none;">
	<div id="tool_tip3">
	   <p>Who is your course intended for? Does a student need any level of knowledge, experience, or ability? Who will benefit most for your course? </p>
		
	</div>
</div> 
 <!--===tooltip Popup 4===-->
 <div style="display:none;">
	<div id="tool_tip4">
	  <p>What kinds of materials will a student need to proceed (like software, specific versions of applications, type of guitar, etc.)? Is there anything a student needs to know coming into the course (prerequisite knowledge)?</p>
		
	</div>
</div>
<?php } elseif ($this->params['controller'] == 'courses' && $this->params['action'] == 'coverimage'){ ?>
<!--Coverimage Help Poup-->
<div class="live-sess-popup" id="live-sess-popup" style="display:none">
 <h2>More About Image<span class="close-icon"><a href="#" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup">
	<div class="cont">
		<p>Having a beautiful, clean, non-pixelated course image is vital to hooking new students. After all, it's the first thing potential students see! It's also what is seen most when a student is perusing 1337IOT. Use an image that both represents your course well and coheres to the 480x270 pixel standard. If you have it, we recommend using an image that is 960x540 for optimal display on the iPad.</p>
		<p>If you don't how to make a course image or use an image editing software like Photoshop, there are several courses on 1337IOT that can help.</p>
	</div>	
	<div class="cont">
		<p>Note: All images flagged as inappropriate will be removed immediately, and will delay the course submission process.</p>
	</div>	
  </div>
 </div> 
<div class="blackOpcty_quote" style="display:none"></div>
<!--Help Poup-->
<?php } elseif ($this->params['controller'] == 'courses' && $this->params['action'] == 'promovideo'){ ?>
<!--Help Poup-->

<div class="live-sess-popup" style="display:none">
	<h2>More About Privacy<span class="close-icon"><a href="#" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
	<div class="help-popup">
		<div class="cont">
			<p>
				<h3>Public</h3>
				"Public" courses are available for anyone to take on IOT 1337.

			</p>
		</div>
		<div class="cont">
			<p>
				<h3>Private</h3>
				"Private" courses are only accessible by direct URLs. They won't show up on IOT's site search. This is a terrific way to offer a course to an exclusive, select group of students.
				<ul>
				<li><strong>"Invitation Only" courses require instructors to invite students by email.</strong> <br />

					"Invitation Only" courses don't show up on IOT's site search, but you can still share they course with your contacts. So, for example, if you have a class of 20 students and you already have their email addresses, you can send direct invitations to the course. A student can only access the course by this email, so tell them to be careful not to lose it!</li><br />
				<li><strong>"Password Protected" courses require students to enter a password to access a course.</strong> <br />

					"Password Protected" courses don't show up on IOT's site search, but you can still share your course with a select group of contacts. If you have a large group of students, instead of inviting individuals by email, set a password so that is the only key a student would need to join your course. A student would go to your course landing page, click Join, and enter the password.</li>
				</ul>
			</p>
		</div>	
	</div>
</div> 
<div class="blackOpcty_quote" style="display:none"></div>
<?php } elseif ($this->params['controller'] == 'courses' && $this->params['action'] == 'price'){ ?>
<!--Help Poup-->
 
 <div class="live-sess-popup" style="display:none">
 <h2>Price Settings<span class="close-icon"><a href="#" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup">
	<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
		<div class="tabs_outer">
		<br />
			<div id="tabs" class="tabs-pop">
				<label class="pvy_set">Price Settings</label>
				<ul>
					<li id="Free" class="priceSetting"><a href="#tabs-1">Free</a></li>
					<li id="Paid" class="priceSetting"><a href="#tabs-2">Paid</a></li>
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
						
						if($this->data['Course']['pricetype'] == "Paid"){
							echo '$'.$this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"label"=>false,"value"=>$this->data['Course']['price']));
						} else{
							echo '$'.$this->Form->input('price',array("type"=>"text","maxlength"=>8, "div"=>false,"placeholder"=>"$ Set a Price","disabled"=>true,"label"=>false));
						}
						?>
						
					</p>
					<div class="error-message"></div>
				</div>
				<p class="crs_note">
					TIP: Your course should be priced: Fairly based on the amount and quality of course content. Competitively based on other courses found on IOT 1337 and other e-Learning sites.
				</p>
			</div>							
		</div>
		<p class="txt-center"><?php echo $this->Form->submit("Save",array('label'=>false,'div'=>false,'class'=>'save_btn','id'=>'savePrice')); ?></p>
	<?php echo $this->Form->end(); ?>
 </div>
 </div> 
   <div class="blackOpcty_quote" style="display:none"></div>
<!--Help Poup--> 
<?php } elseif ($this->params['controller'] == 'courses' && $this->params['action'] == 'privacy'){ ?>
<!--Help Poup-->
 <div class="live-sess-popup" style="display:none">
 <h2>More About Privacy<span class="close-icon"><a href="" id="closeMe" title="Close"><img src="<?php echo $this->webroot;?>img/close-icon.png" width="14" height="14" alt="Close"></a></span></h2>
 <div class="help-popup" >
	<div class="cont">
		<p>
			<h3>Public</h3>
			"Public" courses are available for anyone to take on IOT 1337.

		</p>
	</div>
	<div class="cont">
		<p><h3>Private</h3>
		"Private" courses are only accessible by direct URLs. They won't show up on IOT's site search. This is a terrific way to offer a course to an exclusive, select group of students.
		<ul>
		<li><strong>"Invitation Only" courses require instructors to invite students by email.</strong> <br />

    "Invitation Only" courses don't show up on IOT's site search, but you can still share they course with your contacts. So, for example, if you have a class of 20 students and you already have their email addresses, you can send direct invitations to the course. A student can only access the course by this email, so tell them to be careful not to lose it!</li><br />
    <li><strong>"Password Protected" courses require students to enter a password to access a course.</strong> <br />
	
    "Password Protected" courses don't show up on IOT's site search, but you can still share your course with a select group of contacts. If you have a large group of students, instead of inviting individuals by email, set a password so that is the only key a student would need to join your course. A student would go to your course landing page, click Join, and enter the password.</li>
	</ul>
		</p>
	</div>	
	</div>
 </div> 
   <div class="blackOpcty_quote" style="display:none"></div>
<!--Help Poup-->
<?php } ?>
