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

?>

<div class="program_img">
    <img class="program_img" src="<?= OWEB_HTML_URL_IMG.$this->program->getImg(); ?>" />
</div>

<p class="program_name"><span class="title">Program Name : </span><?=$this->program->getName();?></p>
<p class="program_lversion_name"><span class="title">Last Version Name: </span>notCoded</p>
<p class="program_lupdate"><span class="title">Last Update : </span>notCoded</p>
<p class="program_pdate"><span class="title">Publish Date : </span><?=date("d/m/Y",$this->program->getDate());?></p>
<p class="program_desc"><?=$this->program->getVeryShortDescription('eng');?></p>