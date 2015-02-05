<div class="paging pagination_box">
	<?php
		echo $this->Paginator->prev(('Prev'), array(), null, array('class' => 'prev_pagination_lnk disabled'));
		echo $this->Paginator->numbers(array('separator' => '',"class"=>"pge_no"));
		echo $this->Paginator->next(__('Next'), array(), null, array('class' => 'next_pagination_lnk disabled'));
	?>
</div>
