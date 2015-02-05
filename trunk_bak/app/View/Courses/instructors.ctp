<div class="container">
	<?php echo $this->element('coursesLeft');?>
	<section class="right-panel">
		<h1>Instructor Permissions
		<span>&nbsp;</span>
		</h1>
	<div class="account-cont">
	<?php echo $this->Form->create('Course',array("enctype"=>"multipart/form-data","class"=>"profile_bx")); ?>
	<div class="row">
				<div class="category-box-text">
					<h2>Permissions</h2>
					Manage all instructor permissions for your course.
				</div>
		<div class="lft">
		<div class="manage-instruc">
			<div class="tbl">
				<div class="th">
					<span class="col1 dbl-bdr">Instructor</span>
					<!-- <span class="col2 dbl-bdr">Visible</span> -->
					<span class="col3 dbl-bdr">Can Edit</span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr">Revenue</span>
					<?php } ?>
					<span class="col6 dbl-bdr">Payment Status</span>
					<span class="col5">Delete</span>
				</div>
				<div class="tr">
					<span class="col1 dbl-bdr">1337 IOT</span>
					<!-- <span class="col2 dbl-bdr"><input type="checkbox" disabled checked /></span> -->
					<span class="col3 dbl-bdr"><input type="checkbox" disabled checked /></span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr"><?php echo SITE_COMMISSION."%"; ?></span>
					<?php } ?>
					<span class="col5 "></span>
				</div>
			</div>
			<div class="tbl">
				<div class="th">
					<span class="col1 dbl-bdr">Instructor</span>
					<!-- <span class="col2 dbl-bdr">Visible</span> -->
					<span class="col3 dbl-bdr">Can Edit</span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr">Revenue</span>
					<?php } ?>
					<span class="col6 dbl-bdr">Payment Status</span>
					<span class="col5">Delete</span>
				</div>
				<div class="tr">
					<span class="col1 dbl-bdr"><?php echo $this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"); ?></span>
					<!-- <span class="col2 dbl-bdr"><input type="checkbox" disabled checked /></span> -->
					<span class="col3 dbl-bdr"><input type="checkbox" disabled checked /></span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr"><?php echo $this->Form->input("commission.".$courseownerid,array("type"=>"text","value"=>$usercommission,"label"=>false,"div"=>false)); ?></span>
					<?php } else { ?>
					<span class="col4 dbl-bdr" style="display:none;"><?php echo $this->Form->input("commission.".$courseownerid,array("type"=>"text","value"=>$usercommission,"label"=>false,"div"=>false)); ?></span>
					<?php } ?>
					<span class="col5"></span>
				</div>
			</div>
				<?php $i=0; foreach($courseinstructors as $key=>$val) { ++$i; ?>
				<div class="tbl">
				<div class="th">
					<span class="col1 dbl-bdr">Instructor</span>
					<!-- <span class="col2 dbl-bdr">Visible</span> -->
					<span class="col3 dbl-bdr">Can Edit</span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr">Revenue</span>
					<?php } ?>
					<span class="col6 dbl-bdr">Payment Status</span>
					<span class="col5">Delete</span>
				</div>
				<div class="tr">
					<span class="col1 dbl-bdr"><?php echo ucwords($val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']); ?></span>
					<!-- <span class="col2 dbl-bdr"><?php //echo $this->Form->input("visible.".$val['CourseInstructor']['id'],array("type"=>"checkbox","label"=>false,"div"=>false,empty($val['CourseInstructor']['visible'])?'':'checked')); ?></span> -->
					<span class="col3 dbl-bdr"><?php echo $this->Form->input("editpermission.".$val['CourseInstructor']['id'],array("type"=>"checkbox","label"=>false,"div"=>false,empty($val['CourseInstructor']['editpermission'])?'':'checked')); ?></span>
					<?php if($this->data['Course']['pricetype'] == 'Paid') { ?>
					<span class="col4 dbl-bdr"><?php echo $this->Form->input("commission.".$val['CourseInstructor']['id'],array("type"=>"text","value"=>$val['CourseInstructor']['commission'],"label"=>false,"div"=>false,"maxlength"=>"2","class"=>"commissionval")); ?>
					</span>
					<?php } else { ?>
					<span class="col4 dbl-bdr" style="display:none;"><?php echo $this->Form->input("commission.".$val['CourseInstructor']['id'],array("type"=>"text","value"=>$val['CourseInstructor']['commission'],"label"=>false,"div"=>false,"maxlength"=>"2","class"=>"commissionval")); ?></span>
					<?php } ?>
					<span class="col6" style="<?php echo !empty($val['Userdetail']['paypalaccount'])?"color:green;":"color:red;"; ?>"><?php echo !empty($val['Userdetail']['paypalaccount'])?"Verified":"Not-Verified"; ?></span>
					<span class="col5"><?php echo $this->Html->link($this->Html->image("delete-icon.png", array("alt" => "delete")),array("controller"=>'course-manage',"action"=>'delete-instructor',$val['CourseInstructor']['id'],$val['CourseInstructor']['course_id']), array("escape"=>false),__('Are you sure you want to delete instructor  %s?', ucwords($val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']))); 
					
					?></span>
				</div>
				</div>
				<?php } ?>
				</div>
				</div>
				</div>
				<p>*Note : Only the Primary reciever will be the commission payer for the course purchase transaction.</p>
				<p>*Note : Only four instructors apart from Course Creator and 1337 Institute Instructor can be added for a course.</p>
				<div class="clear-fix"></div>
				<?php if($i < 4) { ?>
					<div class="row">
						<div class="category-box-text">
							<h2>Add Instructor</h2>
						</div>
						<div class="add-instr">
							<span class="thum-img"><img src="<?php echo $this->webroot;?>img/instor-thum.png" width="37" height="37" alt="Add Instructor" /></span>
							<?php echo $this->Form->input('instructors',array("type"=>"text","div"=>false,"label"=>false,"autocomplete"=>"off")); ?>
							<?php echo $this->Form->input('CourseInstructor.user_id',array("type"=>"hidden","div"=>false,"label"=>false,"value"=>"")); ?>
							<?php echo $this->Form->submit('Add Instructor',array("class"=>"add-instr-btn")); ?>
							<div id="instructcont" class="hide overlaycont"></div>
							<!--<input name="" id="" type="submit" value="Add Instructor" title="Add Instructor" class="add-instr-btn" />-->
							<p class="sml-txt1">&nbsp;</p>
						</div>
					</div>
					<br />
				<?php } else { ?>
					<p>*Note : You need to delete an existing instructor before adding a new instructor to course.</p>
				<?php } ?>
		</div>
		<p class="txt-center btn-padding">
			<em class="error" id="revenue_err" style="display:none;">Please enter valid revenue value.</em>
			<?php echo $this->Form->submit("Save",array("label"=>false,"div"=>false,"class"=>"save-btn")); ?>
		</p>
		<?php echo $this->Form->end();?>
	
	</section>
</div>
