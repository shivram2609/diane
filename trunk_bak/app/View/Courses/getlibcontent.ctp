<?php echo $this->Html->script("functionality"); ?>
<ul style="float:left;width:100%;">
	<?php if(!empty($data)) { ?>
	<?php echo $this->Form->hidden("thislectid",array("value"=>$lecid)); ?>
		<?php foreach($data as $key=>$val) { ?>
			<li style="float:left;width:100%;line-height: 50px;">
				<span><?php echo $val['CourseLecture']['heading']; ?></span>
				<a href="javascript:void(0);" id="<?php echo $val['CourseLecture']['id']; ?>" val="<?php echo $type; ?>" class="selectlibrarycontent" style="color: #1B9ED5;float: right;font-size: 12px;padding: 0;width: 100px;">Select Content</a>
				<a href="<?php echo $this->Html->url("/v/".$val['CourseLecture']['id']."/".$this->Common->makeurl($val['CourseLecture']['heading'])); ?>" style="color: #1B9ED5;float: right;font-size: 12px;padding: 0;width: 115px;" target="_blank">Preview Content</a>
			</li>
		<?php } ?>
	<?php } else { ?>
		<li>No Records Found.</li>
	<?php } ?>
</ul>
