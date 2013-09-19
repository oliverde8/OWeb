<?php

namespace OWeb\manage\modes;

/**
 * Description of Page
 *
 * @author De Cramer Oliver
 */
class Page extends AbsMode{
	
	
	
	public function init(){
		//On va charger le controleur.
		$man_ctr = \OWeb\manage\Controller::getInstance();
		
		//On va voir quel page on doit charger
		$get = \OWeb\OWeb::getInstance()->get_get();
		
		if(isset($get['page'])){
			$ctr = $get['page'];
		}else{
			$ctr = OWEB_DEFAULT_PAGE;
		}

		try{
		
		$ctr = str_replace("\\\\", "\\", $ctr);
		$ctr = str_replace(".", "\\", $ctr);
		
		$ctr = $man_ctr->loadController('Page\\'.$ctr);
		$ctr->loadParams();
		}catch(\Exception $ex){
			$ctr = $man_ctr->loadController('Page\OWeb\errors\http\NotFound');
			$ctr->loadParams();
		}
	}
	
	public function display(){
		new \OWeb\manage\Template();
	}
}

?>
