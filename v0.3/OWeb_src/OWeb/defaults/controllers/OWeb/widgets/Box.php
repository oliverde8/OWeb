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

namespace Controller\OWeb\widgets;


use OWeb\types\Controller;

class Box extends Controller{


    public function init()
    {

    }

    public function onDisplay()
    {
        $temp = $this->getParam('Html Class');
        $this->view->class = $temp != null ? $temp : "";

        $temp = $this->getParam('SecondBoxHeight');
        $this->view->SecondBoxHeight = $temp != null ? $temp.'px' : "300px";

        $this->view->ctr = $this->getParam('ctr');
        $this->view->SecondBoxContent = $this->getParam('SecondBoxContent');

        $this->view->clickClass = $this->getParam('clickClass');

        $this->view->desc = $this->getParam('description');
    }
}