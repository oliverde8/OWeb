<?php

namespace OWeb\manage;

/**
 * 
 * Manages the initiation of the main controller represented in the page directory. 
 * Will also manage the action the main controller needs to do.
 *
 * @author De Cramer Oliver
 */
class Controller extends \OWeb\utils\Singleton{
	
	private $controller = null;
	
	private $loaded = false;
	
	function __construct() {
		$events = \OWeb\manage\Events::getInstance();
		$events->registerEvent('Init@OWeb', $this, 'initController');
	}
	
	

	/**
	 * Will initialize the Controller and will do the Actions to which the Controller has register
	 * 
	 * @todo public and change it so it uses the controller in parameter. Change also the way the event is set!!
	 * @param \OWeb\types\Controller $controller The controller to Initialize
	 */
	public function initController(\OWeb\types\Controller $controller=null){
		$this->controller->init();
		
		\OWeb\manage\Events::getInstance()->sendEvent('Init@OWeb\manage\Controller',$this->controller);
		
		//gestion des Actions...
		$get = \OWeb\OWeb::getInstance()->get_get();
		
		if(isset($get['action']))
			$this->controller->doAction($get['action']);
		
		$i=1;
		while (isset($get['action_'.$i])){
			$this->controller->doAction($get['action_'.$i]);
			$i++;
		}
	}
	
	/**
	 * Will load the Controller as main controller. 
	 * Will automaticlly set up the initialisation sequence for the Controller.
	 * The Controller will be initialized once OWeb has finished initialisation.
	 * 
	 * @param type $name of the Controller to load.
	 * @throws \OWeb\manage\exceptions\Controller If there is a error to the loading of the COntroller
	 */
	public function loadController($name){
		
		if( $this->controller != NULL){
			throw new \OWeb\manage\exceptions\Controller("A Controller was already loaded");
		}else{
			
			try{
				$controller = new $name();
				$this->controller = $controller;
				if(! ($controller instanceof \OWeb\types\Controller))
					throw new \OWeb\manage\exceptions\Controller("A Controller needs to be an instance of \OWeb\Types\Controller");	
				
				\OWeb\manage\Events::getInstance()->sendEvent('loaded@OWeb\manage\Controller',$this->controller);
				
			}catch(\Exception $ex){
				throw new \OWeb\manage\exceptions\Controller("The Controller couldn't be loaded due to Errors",0,$ex);
			}
		}
		return $this->controller;
	}
	
	public function loadException($exception){
		unset($this->controller);
		$this->controller = null;
		
		return $this->loadController('Controller\OWeb\Exception');
	}
	
	/**
	 * Will start the display sequence of the controller. 
	 * First will prepare controller for display.
	 * Then it will ask the controller to display it's View.
	 * 
	 * @throws \OWeb\manage\exceptions\Controller If there is a problem about Displaying the Controller
	 */
	public function display(){
		if( $this->controller != NULL){
			try{
				$this->controller->display();
			}catch (\Exception $ex){
				throw new \OWeb\manage\exceptions\Controller("The Controller couldn't be shown due to Errors",0,$ex);
			}
		}else{
			throw new \OWeb\manage\exceptions\Controller("A Controller wasn't loaded to be shown");
		}
	}
	
	
}

?>
