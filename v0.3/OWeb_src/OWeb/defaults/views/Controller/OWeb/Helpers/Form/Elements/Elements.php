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


?>

<label <?=$this->htmlIdentifier?> for="<?=$this->name?>"><?= $this->title ?></label>
<input <?=$this->htmlIdentifier?> type="<?=$this->type?>" name="<?=$this->name?>" value="<?=$this->val?>">

<?php
	if($this->desc != null){
?>
		<img <?=$this->htmlIdentifier?> src="<?= OWEB_HTML_DIR_CSS ?>/images/Helpers_Form/description.png" />

		<span <?=$this->htmlIdentifier?> ><?= $this->desc ?> </span>

<?php
	}
	
	if(!empty($this->errMessages)){
?>
		<div <?=$this->htmlIdentifier?> >
			<ul <?=$this->htmlIdentifier?> >
				
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

