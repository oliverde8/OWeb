

<div class="categoryDescription">
	<p>
		<h3 class="categoryDescription">
			<?php
			\OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\Category_Parents')
			->addParams('cat', $this->mcat)	
			->display();?>
		</h3>
		<h1 class="categoryDescription">
			<?php echo $this->mcat->getName(); ?>
		</h1>
	</p>

	<?php if($this->mcat->getImg()!=NULL){ ?>
			<img class="categoryDescription" src="<?php echo OWEB_HTML_URL_IMG."/".$this->mcat->getImg(); ?>" />
	<?php }
			if($this->mcat->getDescription() != ""){ ?>
	<p>
		<?php echo $this->mcat->getDescription(); ?>
	</p>	
	<?php } ?>
	
</div>



