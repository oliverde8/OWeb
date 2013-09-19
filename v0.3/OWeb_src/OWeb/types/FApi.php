<?php

namespace OWeb\types;

/**
 * Description of FApi
 *
 * @author oliverde8
 */
abstract class FApi extends Controller{
	
	public function display($ctr=null) {
		$this->onDisplay();
	}
	
}

?>
