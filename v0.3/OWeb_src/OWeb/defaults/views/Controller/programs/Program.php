<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);
$this->addHeader('programs.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery_theme/jquery-ui-1.9.2.custom.min.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery-ui-1.9.2.custom.min', \OWeb\manage\Headers::javascript);

$this->addHeader('  <script>
  $(function() {
    $( ".Description > .tabs" ).tabs();
  });
  </script>', \OWeb\manage\Headers::code);

?>

<div id="twoCollone">
    <div>
        <div class="ColloneGauche">
            <div>
                <p> <?php
                    \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Category_Parents')
                        ->addParams('cat', $this->program->getCategory())
                        ->addParams('link', new OWeb\utils\Link(array('page' => 'programs\Categorie', "catId"=>"")))
                        ->display();
                    ?></p>
                <h1><?= $this->program->getName() ?> </h1>


                <div  class="program_info">

                    <?php
                    $prog_display = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\programs\widgets\ProgramCard');

                    $box_program = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Box');
                    $box_program->addParams('ctr', $prog_display)
                        ->addParams('SecondBoxHeight', 500)
                        ->addParams('Html Class', 'programBox');
                    $prog_display->addParams('prog', $this->program);
                    $box_program->display();



                    $box_download = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Box');
                    $dwld_display = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\programs\widgets\Downloads');
                    $dwld_display->addParams('prog', $this->program);
                    $box_download->addParams('ctr', $dwld_display)
                        ->addParams('Html Class', 'DwldBox');
                    $box_download->display();
                    ?>


                    <div class="ColloneClean"></div>

                    <div class="Description">

                        <div class="tabs">
                            <ul>
                                <li><a href="#tabs-1">Description</a></li>
                                <li><a href="#tabs-2">Gallery</a></li>
                                <li><a href="#tabs-3">ChangeLog</a></li>
                            </ul>
                            <div id="tabs-1">

                                <?php
                                    if($this->program->getDesc_article() == null)
                                        echo '<p>'.$this->program->getShortDescription('eng').'</p>';
                                    else{

                                        $article_show = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\show_article\Def');
                                        $article_show->addParam('article', $this->program->getDesc_article());
                                        $article_show->display();

                                    }

                                ?>

                            </div>
                            <div id="tabs-2">
                                <p>Coming Soon </p></div>
                            <div id="tabs-3">
                                <p> Coming Soon</p></div>
                        </div>



                    </div>


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
