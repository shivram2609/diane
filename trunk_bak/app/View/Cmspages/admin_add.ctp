<?php echo $this->element("admins/common",array("place"=>'Search by title,content',"flag"=>false,"pageheader"=>'',"buttontitle"=>'Add Blog',"listflag"=>false)); ?>
<div class="pages form">
<?php echo $this->Form->create('Cmspage');?>
	<fieldset>
		<legend><?php echo __('Add Page'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('content');
		echo $this->Form->input('metatitle',array("label"=>"Meta Title"));
		echo $this->Form->input('seourl',array("label"=>"Seo Url"));
		echo $this->Form->input('metadesc',array("label"=>"Meta Description"));
		echo $this->Form->input('metakeyword',array("label"=>"Meta Keyword"));
		echo $this->Form->input('status',array("type"=>"checkbox","label"=>"Active"));
		echo $this->Form->input('showinfooter',array("type"=>"checkbox","label"=>"Show in Footer"));
		echo $this->Form->input('showinleft',array("type"=>"checkbox","label"=>"Show in Left Panel"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));
echo $this->Fck->load("CmspageContent");
?>
</div>
