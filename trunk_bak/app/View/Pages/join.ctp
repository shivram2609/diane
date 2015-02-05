<!--====Body Section Start====-->
<div class="container">
	<div class="our-faculty">
		<h1>Join Our Faculty<br /> <span>Create a course for free!</span></h1>
		<div class="bullet-cont">
			<h2>On 1337 Institute of Technology:</h2>
			<ul>
				<li>There are no costs to create a course</li>
				<li>You earn a flat 85% of your course revenue</li>	
				<li>We take care of Customer service</li>	
				<li>We take care of all hosting fees</li>
				<li>Creating on our platform is so easy</li>
			</ul>
		</div>
		<div class="contnt-box">
			
			<p>We are looking for talented and innovative tech-savy individuals to teach online. If you are a trainer, professor, teacher or subject matter expert in any technological area with a strong desire to make a difference and reach a massive audience, then come and join our faculty. </p>
			<div class="decide-box">
				<h3>You Decide</h3>
				The content, the delivery AND how much to charge
				<?php if($this->Session->read("Auth.User.id")) { ?>
					<a href="<?php echo $this->Html->url("/course-manage/create"); ?>" class="create-acct" >Teach Online</a>
				<?php } else { ?>
					<a href="<?php echo $this->Html->url("/signup"); ?>" class="create-acct wishlist" >Create An Account</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<!--====Body Section End====-->
