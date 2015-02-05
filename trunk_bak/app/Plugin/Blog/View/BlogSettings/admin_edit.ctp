<div class="blogSettings form">
	<div class="rhs_actions2" style="float:right;">
		<?php echo $this->Html->link(__('List Blog Settings'), array('action' => 'index'));?>
</div>
<?php echo $this->Form->create('BlogSetting');?>
	<fieldset>
		<legend><?php __('Admin Edit Blog Setting'); ?></legend>
	<?php
		echo $this->Form->input('id');
		$options = array(
			'type' => 'textarea',
			'label' => $blogSetting['BlogSetting']['setting_text'],
		);
		if (!empty($blogSetting['BlogSetting']['tip'])) {
			$options['after'] = '<p class="tip">'.$blogSetting['BlogSetting']['tip'].'</p>';
		}
		echo $this->Form->input('value', $options);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

