<?php

namespace OWeb\utils\link;

/**
 * Description of Default
 *
 * @author De Cramer Oliver
 */
class Default_generator implements \OWeb\utils\link\Generator{
	
	public function generate_LinkString($array) {
		$link = "";
		if(isset($array['page'])){
			$link = str_replace("\\", '.', $array['page']).'.html';
			unset($array['page']);
		}
		
		$link .= "?"; 
		foreach($array as $name => $value){
			$link .="$name=$value&";
		}
		return substr($link, 0, strlen($link)-1);
	}
}
?>
