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
namespace Controller\programs;
use Model\articles\Artciles;
use Model\articles\Categories;
use Model\programs\Programs;

/**
 * Description of Categorie
 *
 * @author oliverde8
 */
class Categorie  extends \OWeb\types\Controller{
	
	private $categories;
    private $programs;
	
	public function init() {
        $this->applyTemplateController('Controller\programs\Template');
		$this->InitLanguageFile();
		$this->categories = new \Model\programs\Categories();
        $this->programs = new Programs($this->categories, new Artciles(new Categories()));


	}

	public function onDisplay() {
		$this->view->cats = $this->categories;
		$this->view->category = $this->categories->getElement($this->getParam('catId'));
        $this->view->programs = $this->programs->getPrograms($this->view->category, 0, 100, true);
	}
	
}

?>
