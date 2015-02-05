<div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Profile Image'); ?></dt>
		<dd>
			<?php echo (!empty($user['Userdetail']['image'])?$this->Html->image($user['Userdetail']['image']):''); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($user['User']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Industries'); ?></dt>
		<dd>
			<?php 
			if (!empty($industries)) {
				$i = 0;
				foreach($industries as $key=>$val) {
					if ($i > 0) {
						echo " | ";
					}
					echo h($val['Industry']['heading']); 
					$i++;
				}
			} else {
				echo "--Not Selected--";
			}
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mediaoutlet'); ?></dt>
		<dd>
			<?php 
			if (!empty($mediaoutlets)) {
				$i = 0;
				foreach($mediaoutlets as $key1=>$val1) {
					if ($i > 0) {
						echo " | ";
					}
					echo h($val1['Mediaoutlet']['heading']." : ".$val1['Usermediaoutlet']['mediaval']); 
					$i++;
				}
			} else {
				echo "--Not Selected--";
			} ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($user['User']['status']==1?'Active':'Inactive'); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created On'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></dt>
		<dd>
			&nbsp;
		</dd>
	</dl>
</div>
