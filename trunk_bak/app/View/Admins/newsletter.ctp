<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<?php echo $this->element("admins/common",array("place"=>'Search by state name or country name',"flag"=>false,"pageheader"=>'Newsletter',"buttontitle"=>'Add State',"listflag"=>false)); ?>
<div class="blogs form">
<?php 
echo $this->Session->flash();
echo $this->Form->create("Newsletter");
?>
<fieldset>
 		<legend><?php __('Newletters'); ?></legend>
<?php
echo $this->Form->input("subject",array("label"=>"Email Subject"));
echo $this->Form->input("from",array("label"=>"Email From"));
echo $this->Form->input("content",array("type"=>"textarea","label"=>"Email Content"));
?>
<p id="selectall">Add All Users</p>
<label class="error hide">Please select atleast one user.</label>
<div id="userslist">
	<ul>
		<?php foreach($users as $key=>$val) { ?>
			<li class="user_list" val="<?php echo empty($val['Userdetail']['email'])?$val['User']['username']:$val['Userdetail']['email']; ?>">
				<?php 
				// use thumb path from helper
				$profileImgPathThumb = ((!empty($val['Userdetail']['image']) && file_exists(WWW_ROOT.$val['Userdetail']['image']))?$val['Userdetail']['image']: "/img/no-img.png");
				$profileImgThumb = $this->Common->getImageName($profileImgPathThumb, ThumbImageProfilePrefix);

				 echo $this->Html->image($profileImgThumb,array("alt"=>$val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name'],"width"=>"34px","height"=>"34px"));
				 ?>
				 <p><?php echo $val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']; ?></p>
			</li>
		<?php } ?>
	</ul>
</div>
<?php
echo $this->Form->input("sentusers",array("type"=>"textarea","class"=>"hide","label"=>false,"div"=>false));
echo $this->Form->Submit("Submit");
echo $this->Form->end();
echo $this->Fck->load('NewsletterContent');
?>
</div>
