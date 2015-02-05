<div class="container">
		<aside class="left-bar1">
			<?php //pr($this->params);?>
			<ul>
				<?php foreach($pagesName as $page): ?>
					<li class="<?php if($this->params['pass'][0] == $page['Cmspages']['seourl']) echo 'selected';?>"><a href="<?php echo $this->Html->url("/st/".$page['Cmspages']['seourl']); ?>" title="Terms of use"><?php echo $page['Cmspages']['name'];?></a></li>
				<?php endforeach;?>
			</ul>
		</aside>
	<section class="right-panel-1">
		<h1><?php echo $pageContent['Cmspages']['name'];?></h1>
		<?php echo $pageContent['Cmspages']['content'];?>
	</section>
		
</div>
