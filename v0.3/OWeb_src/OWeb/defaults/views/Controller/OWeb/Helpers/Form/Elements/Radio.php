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

/**
 * Description of Elements
 *
 * @author De Cramer Oliver
 */

$js = "
	$('span.OWebForm_input').css('display', 'block').hide();
	$('img.OWebForm_input').click(function(){
		if( $(this).next().is(':visible') )
			$(this).next().fadeOut();
		else {
			$(this).next().fadeIn();
		}
	});

";
\OWeb\utils\js\jquery\HeaderOnReadyManager::getInstance()->add($js);

$id = clone $this->htmlIdentifier;
$id->addHtmlClass('OWebForm_input_def');

$idRadio = clone $this->htmlIdentifier;
$idRadio->addHtmlClass('OWebForm_input_radio');

$idDesc = clone $this->htmlIdentifier;
$idDesc->addHtmlClass('OWebForm_input_desc');

$idErr = clone $this->htmlIdentifier;
$idErr->addHtmlClass('OWebForm_input_err');

?>

<label <?=$id?> for="<?=$this->name?>"><?= $this->title ?></label>

<?php

foreach($this->radios as $radio){
 $checked = $radio[1] == $this->val ? 'checked' : '';
?>

<input <?=$idRadio?> type="<?=$this->type?>" name="<?=$this->name?>" value="<?=$radio[1]?>" <?=$checked?>> 
<label <?=$idRadio?> ><?=$radio[0]?></label>

<?php

}
	if($this->desc != null){
?>
		<img <?=$idDesc?> src="<?= OWEB_HTML_DIR_CSS ?>/images/Helpers_Form/description.png" />

		<span <?=$idDesc?> ><?= $this->desc ?> </span>

<?php
	}
	
	if(!empty($this->errMessages)){
?>
		<div <?=$idErr?> >
			<ul <?=$idErr?> >
				
				<?php
					foreach($this->errMessages as $i => $msg){
				?>
				
				<li>
					<strong><?=$msg?> </strong>
					<?=$this->errDescriptions[$i]?>
				</li>
				
				<?php
					}
					
				?>
				
			</ul>	
		</div>
<?php } ?>

