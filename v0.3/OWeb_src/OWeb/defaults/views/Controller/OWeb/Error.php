<?php
header("Status: 404 Not Found");
$this->addHeader('2Collone.css',\OWeb\manage\Headers::css); 
$this->addHeader('_OWeb/errors/errors.css',\OWeb\manage\Headers::css); 
?>

<div id="twoCollone">
	
	<div class="contenuMain">
		<div class="OWeb_error">
			<div>
				<?php 
				if(!empty($this->img)){
				?>
					<img src="<?php echo $this->img; ?>" desc="Error Image"/>
				<?php } ?>
				
				<h1>Error : <?php echo $this->title; ?></h1>
				
				<p> 
					<?php echo $this->desc; ?>

				</p>
				
				<div class="end"></div>
			</div>
		</div>
	</div>
	
</div>
