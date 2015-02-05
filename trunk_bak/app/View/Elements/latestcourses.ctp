<div id="course-categ">
	<?php if($this->params['controller'] == 'pages') { ?>
		<div class="txt_bak technologies_courses"><span class="total_course_label"><a href="<?php echo $this->Html->url("/view-courses"); ?>"><?php echo isset($countcourse)?$countcourse:'0'; ?></a> Technology Courses and Growing...</span>	</div>
	<?php } ?>
	<div class="course-categ ">
		<div class="course_header"><span>Course Categories</span></div>
		<ul>
			<li>
				<a href="<?php echo $this->Html->url("/view-courses/programming-languages/33"); ?>" title="Programming" ><?php echo $this->Html->image("/img/programming.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/programming-languages/33"); ?>" title="Programming" >Programming</a></h2>
			</li>
			<li>
				<a href="<?php echo $this->Html->url("/view-courses/applications/22"); ?>" title="Applications" ><?php echo $this->Html->image("/img/application.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/applications/22"); ?>" title="Applications" >Applications</a></h2>
			</li>
			<li class="last">
				<a href="<?php echo $this->Html->url("/view-courses/software/19"); ?>" title="Software" ><?php echo $this->Html->image("/img/software.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/software/19"); ?>" title="Software" >Software</a></h2>
			</li>
			<li>
				<a href="<?php echo $this->Html->url("/view-courses/hacking/20"); ?>" title="Hacking" ><?php echo $this->Html->image("/img/hacking.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/hacking/20"); ?>" title="Hacking" >Hacking</a></h2>
			</li>
			<li>
				<a href="<?php echo $this->Html->url("/view-courses/games/15"); ?>" title="Games" ><?php echo $this->Html->image("/img/games.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/games/15"); ?>" title="Games" >Games</a></h2>
			</li>
			<li class="last">
				<a href="<?php echo $this->Html->url("/view-courses/design/3"); ?>" title="Design" ><?php echo $this->Html->image("/img/design.jpg",array("alt"=>"","width"=>"310","height"=>"185")); ?></a>
				<h2><a href="<?php echo $this->Html->url("/view-courses/design/3"); ?>" title="Design" >Design</a></h2>
			</li>
		</ul>
	</div>		
	<div class="clear"></div>
</div>
