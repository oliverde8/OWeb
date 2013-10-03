<?php

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);
$this->addHeader('programs.css', \OWeb\manage\Headers::css);

?>

<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
               <p> <?php
                    \OWeb\manage\SubViews::getInstance()->getSubView('Controller\articles\widgets\Category_Parents')
                        ->addParams('cat', $this->category)
                        ->display();
                ?></p>
                <h1><?= $this->category->getName() ?> </h1>
                    <div  class="programs">
<?php

    $prog_display = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\programs\widgets\ProgramCard');

    $box_display = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Box');
    $box_display->addParams('ctr', $prog_display)
        ->addParams('SecondBoxHeight', 500)
        ->addParams('Html Class', 'programBox');

    foreach($this->programs as $program){
        $prog_display->addParams('prog', $program);
        $box_display->addParams('SecondBoxContent', $program->getShortDescription("eng"));
        $box_display->display();
    }

?>

                    </div>
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

