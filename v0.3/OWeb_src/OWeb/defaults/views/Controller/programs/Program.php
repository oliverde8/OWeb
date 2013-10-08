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

?>

<div id="twoCollone">
    <div>
        <div class="ColloneGauche">
            <div>
                <p> <?php
                    \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Category_Parents')
                        ->addParams('cat', $this->category)
                        ->addParams('link', new OWeb\utils\Link(array('page' => 'programs\Categorie', "catId"=>"")))
                        ->display();
                    ?></p>
                <h1><?= $this->category->getName() ?> </h1>
                <div  class="program">
                   
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
