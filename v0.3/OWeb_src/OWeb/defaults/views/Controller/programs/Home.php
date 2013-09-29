<?php

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);

$this->addHeader('Page.Programing.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery.jscrollpane.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery.carousel.css', \OWeb\manage\Headers::css);

$this->addHeader('jquery.easing.1.3.js', \OWeb\manage\Headers::javascript);
$this->addHeader('jquery.mousewheel.js', \OWeb\manage\Headers::javascript);
$this->addHeader('jquery.contentcarousel.js', \OWeb\manage\Headers::javascript);

$carousel_id = 0;



?>
<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
				<h1>Whats new?, Whats going On?</h1>
				<div class="content">

					<img src="<?php echo OWEB_HTML_URL_IMG; ?>/theTardis2.jpg" />
					<h2><?php echo $this->l('onProgress_Title'); ?></h2>

					<p><?php echo $this->l('onProgress_desc'); ?></p>

					<hr>

				</div>
				
				<h1>Projects Overview</h1>
				
				<?php
				$nbT = 0;
				while(isset($this->previews_title[$nbT])){
				?>
				
				<h2>
					<?php echo $this->previews_title[$nbT]; ?>
				</h2>
				
				<div id="prog_carousel_<?php echo $nbT+1; ?>" class="ca-container">
					<div class="ca-wrapper">
						
						<?php
						$num = 0;
						foreach ($this->previews[$nbT] as $prog){
							$num++;
							if(!$prog->getFront_page())
								continue;
                            if(!$prog->checkLang($this->getLang()))
                                $lang = \OWeb\types\Language::$default_language;
                            else
                                $lang = $this->getLang();
						?>
						
						<div class="ca-item ca-item-<?php echo $nbT."-".$num; ?>">
							<div class="ca-item-main">
								<div class="ca-icon">
									<img src="<?php echo OWEB_HTML_URL_IMG.$prog->getImg(); ?>" />
								</div>
								<h3><?php echo $prog->getName(); ?></h3>
								<h4>
									<span><?php echo $prog->getVeryShortDescription($lang); ?></span>
								</h4>
								<a href="#" class="ca-more">more...</a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<a href="#" class="ca-close">close</a>
									<div class="ca-content-text">
									<?php echo $prog->getShortDescription($lang); ?>
									</div>
									<p><a href="http://www.tm-teams.com" class="ca-content-more">More Information &/| Download</a></p>
								</div>
							</div>
						</div>
						
						<?php
						}
						?>
						
					</div>
				</div>
				
				<?php
					$nbT++;
					echo '<script type="text/javascript">
								$(\'#prog_carousel_'.$nbT.'\').contentcarousel();
							</script>';
				}
				?>
				
			</div>
		</div>
		<?php
		$catTree = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\programs\widgets\ColloneDroite');
		$catTree->addParams('cats', $this->cats)
				->display();
		?>
		<div class="ColloneClean"></div>
	</div>
</div>


<script type="text/javascript">
	$('#tm_related').contentcarousel();
	//$('#uni_related').contentcarousel();
</script>