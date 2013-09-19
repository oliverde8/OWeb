<?php

namespace Extension\Javascript;

use OWeb\Type\Extension;

/**
 * 
 * @author Oliver de Cramer
 */
class ajaxPageLoader extends Extension {

	protected function init() {
		
	}

	public function goApi(){
		$list = \OWeb\gerer\enTete::getEntetesLinks();

		echo '{'."\n";
		echo '	"entetes" : [';

		for($i=0; $i<\sizeof($list); $i++){
			if($i == (sizeof($list)-1))
				echo '		{"url": "'.$list[$i].'"}'."\n";
			else
				echo '		{"url": "'.$list[$i].'"},'."\n";
		}

		echo'	]'."\n";
		echo '}'."\n";
	}

}1

?>
