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

$this->addHeader('jquery_theme/jquery-ui-1.9.2.custom.min.css', \OWeb\manage\Headers::css);
$this->addHeader('jquery/jquery-ui-1.9.2.custom.min.js', \OWeb\manage\Headers::javascript);

echo '<div id="'.$this->id.'">';

foreach ($this->sections as $title => $content){

	echo '<h3>'.$title.'</h3>';
	echo '<div>';
	
	if($content instanceof \OWeb\types\Controller)
		$content->display();
	else
		echo $content;
	
	echo '</div>';	
}
?>
</div>