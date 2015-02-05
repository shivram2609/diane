<?php if(!empty($users)) { ?>
<ul>
<?php 
foreach($users as $key=>$val) {
	?>
	<li class="listsearch" id="<?php echo $val['User']['id']; ?>" style="cursor:pointer;">
			<?php	
			if (!empty($val['Userdetail']['image'])) {
				echo $this->Html->image($val['Userdetail']['image'],array("id"=>"instruct_".$val['User']['id']));
			} else { 
				echo $this->Html->image("/img/no-img.png",array("id"=>"instruct_".$val['User']['id']));
			}
			?>
			<p><?php echo $val['Userdetail']['first_name'].' '.$val['Userdetail']['last_name']; ?></p>
	</li>
	<?php
}

?>
</ul>
<?php } else { echo 1;  } ?>
