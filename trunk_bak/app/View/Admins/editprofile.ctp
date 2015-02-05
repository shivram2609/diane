<div class="admindetails form">
<?php echo $this->element("admins/common",array("place"=>'Search by title,content',"flag"=>false,"pageheader"=>'Books',"buttontitle"=>'Add Book',"listflag"=>false)); ?>
<?php echo $this->Form->create('Admindetail',array("enctype"=>"multipart/form-data"));
echo $this->Session->flash(); 
?>
	<fieldset>
		<legend><?php echo __('Edit Profile'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('address');
		echo $this->Form->input('zip');
		echo $this->element("countrystatecity",array("controller"=>"admins"));
		echo $this->Form->input('company');
		echo (!empty($this->data['Admindetail']['company_logo'])?$this->Html->image($this->data['Admindetail']['company_logo']):'').$this->Form->input('company_logo',array("type"=>"file"));
		echo $this->Form->input('signature');
		echo (!empty($this->data['Admindetail']['image'])?$this->Html->image($this->data['Admindetail']['image']):'').$this->Form->input('image',array("type"=>"file","label"=>"Profile Image"));
		echo $this->Fck->load('AdmindetailSignature');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

