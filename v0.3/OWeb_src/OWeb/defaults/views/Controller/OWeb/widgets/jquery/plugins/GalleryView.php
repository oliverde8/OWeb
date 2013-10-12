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


$this->addHeader('jquery_plugins/jquery.timers-1.2.js', \OWeb\manage\Headers::javascript);
$this->addHeader('jquery_plugins/jquery.easing.1.3.js', \OWeb\manage\Headers::javascript);
$this->addHeader('jquery_plugins/jquery.galleryview-3.0-dev.js', \OWeb\manage\Headers::javascript);
$this->addHeader('jquery_theme/jquery.galleryview-3.0-dev.css', \OWeb\manage\Headers::css);

$gallery_id = (String)(new \OWeb\utils\IdGenerator());

$js = "
<script>
    $(document).ready(function () {
        $('#".$gallery_id."').galleryView();
    });
</script>";
$this->addHeader($js, \OWeb\manage\Headers::code);

$files = scandir(OWEB_DIR_DATA.'/'.$this->path);

echo '<ul id="'.$gallery_id.'">';

foreach($files as $file){

    if(!is_dir(OWEB_DIR_DATA.'/'.$this->path.'/'.$file)){

        $exps = explode('.',$file);

        echo '<li>';
        echo '<img src="'.OWEB_WWW_DATA.'/'.$this->path.'/'.$file.'" alt="'.$exps[0].'" />';
        echo '</li>';

    }
}

echo '</ul>';