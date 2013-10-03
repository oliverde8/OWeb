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

if(!empty($this->clickClass)){
    $jsClass = $this->clickClass;
}else{
    $jsClass = "box_content";
}

$js = '<script type="text/javascript">
$(document).ready(function () {

    $(".'.$jsClass.'").click(function () {

        if (!$(this).parent().find(".box_description_content").is(":visible")) {

            $(this).parent().find(".box_description").animate({height: "'.$this->SecondBoxHeight.'"}, 0);
            applyMasonary();
            $(this).parent().find(".box_description").animate({height: "0px"}, 0);

            $(this).parent().find(".box_description").animate({height: "'.$this->SecondBoxHeight.'"}, 500, function () {
                applyMasonary();
                $(this).parent().find(".box_description_content").show(0);
            });

        } else {
            $(this).parent().find(".box_description_content").hide(500, function () {
                $(this).parent().animate({height: "0px"}, 0, function () {
                    applyMasonary();
                });
            });
        }
    });

    function applyMasonary() {

        $(".programs").masonry({
            // options
            itemSelector: ".box"
        });
    }

});
</script>';

$this->addHeader($js, \OWeb\manage\Headers::code);
$this->addHeader('masonry.pkgd.min.js', \OWeb\manage\Headers::javascript);
$this->addHeader('widget_box.css', \OWeb\manage\Headers::css);

?>


    <div class="box <?= $this->class; ?>">

        <div class="box_content">

            <?php $this->ctr->display() ?>

        </div>

        <div class="box_description">
            <div class="box_description_content">
                <?= $this->SecondBoxContent ?>
            </div>
        </div>

    </div>
