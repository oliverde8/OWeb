<?php

$this->addHeader('jquery_theme/jquery-ui-1.9.2.custom.min.css',\OWeb\manage\Headers::css); 
$this->addHeader('jquery-ui-1.9.2.custom.min.js',\OWeb\manage\Headers::javascript); 
$this->addHeader('2Collone.css',\OWeb\manage\Headers::css); 
?>

<div id="twoCollone">
<?php 
	$h='
		 <script>
    $(function() {
        $( "#ex_errors" ).accordion({
            collapsible: true,
			 heightStyle: "content",
			 active : "false"
        });
    });
    </script>';
	$this->addHeader($h,\OWeb\manage\Headers::code);
?>
	
	<div class="contenuMain">
		
		<?php echo '<h2>'.$this->l('title').'</h2>'; ?>
		
		<div id="ex_errors">
		<?php
		//Fatal error: Call to undefined function gets_class() in C:\ption.php on line 28
		foreach($this->messages as $ex){?>
			<h3><?php echo get_class($ex); ?></h3>
			<div>
				<h4><?php echo $ex->getMessage(); ?></h4>
				<ul>
					<li><strong> File : </strong><?php echo $ex->getFile(); ?></li>
					<li><strong> Line : </strong><?php echo $ex->getLine(); ?></li>
					<li><strong> Trace : </strong>
						<ul>
							<?php foreach($ex->getTrace() as $t){ ?>
							<li>
								<strong><?php echo $t['file']; ?></strong>
								<ul>
									<?php 
									unset($t['file']); 
									foreach($t as $n=>$v){?>
										<li><strong><?php echo $n; ?> : </strong><?php echo $v;?></li>								
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		<?php } ?>
		</div>		
	
	</div>
</div>




