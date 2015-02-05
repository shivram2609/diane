<?php $rating1 = number_format($rating,"2",".","")*13; ?>
<a href="javascript:void(0);" title="<?php echo empty($rating)?'No ratings available.':number_format($rating,"2",".","")." ratings"; ?>">
<span class=" grey_star">
	<span class="gold_star" style="width:<?php echo $rating1; ?>px;"></span>
</span>
</a>
