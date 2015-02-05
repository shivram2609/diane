<?php echo $this->Session->flash(); ?>
<?php foreach($coursesection as $key=>$val) { ?>
<div class="profile_header">
	<span class="viewsection<?php echo $val['CourseSection']['id']; ?>">
		<h2 class="heading4">Section <?php echo $val['CourseSection']['section_index']; ?>: <em class="heading_<?php echo $val['CourseSection']['id']; ?>"><?php echo $val['CourseSection']['heading']; ?></em></h2>
		<a href="javascript:void(0);" class="opensectioncont" id="<?php echo $val['CourseSection']['id']; ?>">edit</a>
	</span>
	<span class="editsection<?php echo $val['CourseSection']['id']; ?> hide">
		<h2 class="heading4">Section <?php echo $val['CourseSection']['section_index']; ?>: <?php echo $this->Form->input("CourseSection.heading.".$val['CourseSection']['id'],array("value"=>$val['CourseSection']['heading'],"class"=>"coursesectionval".$val['CourseSection']['id'],"label"=>false,"div"=>false)); ?></h2>
		<input value="Submit" type="button" id="btn_<?php echo $val['CourseSection']['id']; ?>" class="change" />
		<a href="javascript:void(0);" id="cancel_<?php echo $val['CourseSection']['id']; ?>" class="cancel">Cancel</a>
		<input type="hidden" id="hiddenid<?php echo $val['CourseSection']['id']; ?>" value="<?php echo $val['CourseSection']['section_index']; ?>" />
		<input type="hidden" id="hiddencourseid<?php echo $val['CourseSection']['id']; ?>" value="<?php echo $val['CourseSection']['course_id']; ?>" />
		<a href="javascript:void(0);" id="delete_<?php echo $val['CourseSection']['id']; ?>" class="delete">Delete</a>
	</span>
</div>

	<?php if(!empty($val['CourseLecture'])) { ?>
		<?php foreach($val['CourseLecture'] as $key1=>$val1) { ?>
			<div style="float: left; clear: both; height: 2px;">&nbsp;</div>
			<div class="profile_header">
				<span class="viewlecture<?php echo $val1['id']; ?>">
					<label style="margin-left: 8px; width: 96%; line-height:15px;" class="profile_header">Lecture <?php echo $val1['lecture_index'] ?>: <em class="lectureheading_<?php echo $val1['id'] ?>"> <?php echo $val1['heading'] ?></em>
					<a href="javascript:void(0);" class="openlecturecont" id="<?php echo $val1['id']; ?>">edit</a></label>
					<a href="javascript:void(0);" class="addlecturecontent" id="addcontent_<?php echo $val1['id']; ?>">Add Content</a></label>
				</span>
				<div style="float: left; clear: both; height: 2px;">&nbsp;</div>
				<span class="addcontentcontainer<?php echo $val1['id']; ?> hide">
					<label style="margin-left: 8px; width: 96%; line-height:15px;" class="profile_header">Content type<br/>
						<ul class="content">
							<li><a href="javascript:void(0);" class="addlecturevideocontent" id="addlecturevideocontent_<?php echo $val1['id']; ?>">Video</a></li>
							<li><a href="javascript:void(0);" class="addlectureaudiocontent" id="addlectureaudiocontent_<?php echo $val1['id']; ?>">Audio</a></li>
							<li><a href="javascript:void(0);" class="addlecturepresentcontent" id="addlecturepresentcontent_<?php echo $val1['id']; ?>">Presentation</a></li>
							<li><a href="javascript:void(0);" class="addlecturedoccontent" id="addlecturedoccontent_<?php echo $val1['id']; ?>">Document</a></li>
							<li><a href="javascript:void(0);" class="addlecturetextcontent" id="addlecturetextcontent_<?php echo $val1['id']; ?>">Text</a></li>
							<li><a href="javascript:void(0);">Mashup</a></li>
						</ul>
					</label>
				</span>
				<div style="float: left; clear: both; height: 2px;">&nbsp;</div>
				<span class="addvideocontainer<?php echo $val1['id']; ?> hide addcont">
					<?php echo $this->Form->input("video",array("type"=>"file","class"=>"fileoupload","id"=>"video_".$val1['id']."_".$val1['course_section_id']."_".$val1['course_id'])); ?>
					<em>Use .mp4, .mov, or .wmv file no larger than 1.0 GiB.</em>
					<label class="errmsg hide"></label>
				</span>
				<span class="addaudiocontainer<?php echo $val1['id']; ?> hide addcont">
					<?php echo $this->Form->input("audio",array("type"=>"file","class"=>"fileoupload","id"=>"audio_".$val1['id']."_".$val1['course_section_id']."_".$val1['course_id'])); ?>
					<em>Use .mp3, or .wav file no larger than 1.0 GiB.</em>
					<label class="errmsg hide"></label>
				</span>
				<span class="addpresentcontainer<?php echo $val1['id']; ?> hide addcont">
					<?php echo $this->Form->input("Presentation",array("type"=>"file","class"=>"fileoupload","id"=>"presentation_".$val1['id']."_".$val1['course_section_id']."_".$val1['course_id'])); ?>
					<em>Use .pdf file no larger than 1.0 GiB.</em>
					<br/>
					<em>Tip: A presentation means slides (e.g. PowerPoint, Keynote). Slides are a great way to combine text and visuals to explain concepts in an effective and efficient way. Use meaningful graphics and clearly legible text!</em>
					<label class="errmsg hide"></label>
				</span>
				<span class="adddoccontainer<?php echo $val1['id']; ?> hide addcont">
					<?php echo $this->Form->input("Document",array("type"=>"file","class"=>"fileoupload","id"=>"document_".$val1['id']."_".$val1['course_section_id']."_".$val1['course_id'])); ?>
					<em>Use .pdf file no larger than 1.0 GiB.</em>
					<br/>
					<em>Tip: A document lecture is for any type of PDF document or handout for your students. You can make this a downloadable document for easy and quick reference. Make sure everything is legible!</em>
					<label class="errmsg hide"></label>
				</span>
				<span class="addtextcontainer<?php echo $val1['id']; ?> addcont hide">
					<?php echo $this->Form->input("Course.text.".$val1['id'],array("type"=>"textarea","class"=>"addtext","label"=>"Text","value"=>($val1['content_type'] == 'T')?$val1['content']:'')); ?>
					<label class="errmsg hide"></label>
					<?php echo $this->Form->submit("Save"); ?>
				</span>
				<span class="editlecture<?php echo $val1['id']; ?> hide addcont">
					<label style="margin-left: 8px; width: 96%; line-height:15px;" class="profile_header">Lecture <?php echo $val1['lecture_index'] ?>: <?php echo $this->Form->input("CourseLecture.".$val1['id'],array("value"=>$val1['heading'],"div"=>false,"label"=>false,"class"=>"lecture_".$val1['id'])); ?>
					</label>
					<input value="Submit" type="button" id="btn_<?php echo $val1['id']; ?>" class="changelecture" />
					<a href="javascript:void(0);" id="cancel_<?php echo $val1['id']; ?>" class="cancellecture">Cancel</a>
					<input type="hidden" id="hiddenidlecture<?php echo $val1['id']; ?>" value="<?php echo $val1['lecture_index']; ?>" />
					<input type="hidden" id="hiddencourseidlecture<?php echo $val1['id']; ?>" value="<?php echo $val1['course_id']; ?>" />
					<a href="javascript:void(0);" id="deletelecture_<?php echo $val1['id']; ?>" class="deletelecture">Delete</a>
				</span>
			</div>
			<div style="float: left; clear: both; height: 2px;">&nbsp;</div>
		<?php } ?>
	<?php } ?>
<?php } ?>
