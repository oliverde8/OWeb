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

$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);
$this->addHeader('programs.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery_theme/jquery-ui-1.9.2.custom.min.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery.js', \OWeb\manage\Headers::js);
$this->addHeader('jquery-ui-1.9.2.custom.min', \OWeb\manage\Headers::javascript);


$this->addHeader('  <script>
  $(function() {
    $( ".Description > .tabs" ).tabs();
  });
  </script>', \OWeb\manage\Headers::code);
?>


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
                <li><a href="#tabs_prg_description">Description</a></li>
                <?php
                    $galleryPath = $this->program->getGalleryPath();
                    if(!empty($galleryPath)) echo '<li><a href="#tabs_prg_gallery">Gallery</a></li>';

                    $versions = $this->program->getVersions();
                    if(!empty($versions)) echo' <li><a href="#tabs_prg_changelog">ChangeLog</a></li>';
                
					$articles = array();
					foreach($this->program->getArticles() as $article){
						$article_display = 	\OWeb\manage\SubViews::getInstance()->getSubView('Controller\articles\widgets\show_article\\'.$article->getType());
						$article_display ->addParams('article', $article)
								->addParams('short', false)
								->addParams('image_level', 2);
						$id = new \OWeb\utils\IdGenerator();
						echo '<li><a href="#tabs_prg_changelog'.$id.'">'.$article->getTitle('eng').'</a></li>';		
						$articles[(String)$id] = $article_display;
					}
				?>
            </ul>
            <div id="tabs_prg_description">

                <?php
                    if($this->program->getDesc_article() == null)
                        echo '<p>'.$this->program->getShortDescription('eng').'</p>';
                    else{

                        $article_show = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\show_article\Def');
                        $article_show->s('article', $this->program->getDesc_article());
                        $article_show->display();

                    }

                ?>

            </div>

            <?php
            if(!empty($galleryPath)){
                echo '<div id="tabs_prg_gallery">';

                    $gallery_show = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\OWeb\widgets\jquery\plugins\GalleryView');
                    $gallery_show->addParams('path', $galleryPath);
                    $gallery_show->display();

                echo '</div>';
            }

            if(!empty($versions)){

                echo '<div id="tabs_prg_changelog">';
                $gallery_show = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\programs\widgets\ChangeLog');

                foreach($versions as $ver){
                    echo '<h3>'.$ver->getName().'</h3>';
                    $gallery_show->setVersion($ver)
                        ->display();
                }
                echo ' </div>';
            }
			
			foreach($articles as $id => $display){
				echo '<div id="'.$id.'">';
				$display->display();
				echo '</div>';
			}
			

            ?>



        </div>



    </div>


</div>




