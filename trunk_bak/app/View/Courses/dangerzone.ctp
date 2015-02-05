<div class="container">
<?php echo $this->element('coursesLeft');?>
<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
	<section class="right-panel">
		<div class="account-cont">
			<h1>Delete Course<br />
				<!-- <span><?php //echo(($userdetails['Course']['publishstatus'] == 'Publish')?"Unpublish":"Publish"); ?> or delete your course.</span> --><br />
			</h1>
			<div class="row">
				<div class="category-box-text1">
							<h2><?php echo(($userdetails['Course']['publishstatus'] == 'Publish')?"Unpublish":"Publish"); ?> Course</h2>
						</div>
					<div class="delt"><br>
					<div class="txt-center"> <?php //echo(($userdetails['Course']['publishstatus'] == 'Publish')?"Unpublish":"Publish"); ?> <!--Your Course -->
					
						<?php
						if($userdetails['Course']['publishstatus'] == 'Publish') { ?>
							<span class="btn-pub" style="float:none">
								<?php
								echo $this->Html->link("Unpublish",array("controller"=>"course-manage","action"=>"unpublish",$userdetails['Course']['id']), array("class"=>"save-btn","style"=>"height:25px"), __('Are you sure you want to unpublish course %s?',$userdetails['Course']['title']));
								?>
							</span>
						<?php
						} else {
							//echo "<p>Your course is not published yet. In the future, you can unpublish your course here!</p>";
							echo $this->Html->link("Publish",array("controller"=>"course-manage","action"=>"publish",$userdetails['Course']['id']), array("class"=>"save-btn","style"=>"height:25px"));
						}
					?>				
					</span>
						<!--<p>Your course is not published yet. In the future, you can unpublish your course here!</p>		
						<input type="submit" class="save-btn" value="Unpublish" title="Unpublish">							-->
					</div>
				</div>
				</div>
				<div class="row">
				<div class="category-box-text1">
							<h2>Delete Course</h2>
						</div>
					<div class="delt"><br>
					<div class="txt-center">
							
						<?php echo $this->Html->link("Delete",array("controller"=>"course-manage","action"=>"delete-courses",$this->data['Course']['id']), array("class"=>"red-btn", "style"=>"height:25px"), __('Are you sure you want to delete course %s?',$this->data['Course']['title'])); ?>							
					</div>
				</div>
			</div>
		</div>
		</section>		
	<?php echo $this->Form->end(); ?>
</div>	  

