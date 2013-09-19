<?php

namespace OWeb\manage;

/**
 * Manages the event system of OWeb. 
 *
 * @author De Cramer Oliver
 */
class Events extends \OWeb\utils\Singleton{
	
	protected $actions = array();
	
	
	/**
	 * Register a function to be called in a certain event.
	 * 
	 * @param type $event	The name of the Event
	 * @param type $object	The object of which the function will be called
	 * @param type $fn		The name of the function to call
	 */
	public function registerEvent($event, $object, $fn){
		$this->actions[$event][] = new \OWeb\manage\events\Event($object, $fn);
	}
	
	/**
	 * Will send and event and call the functions that has registered to that Event.
	 * 
	 * @param type $event The name of the Event
	 * @param type $params The parameters array you want to send with the event.
	 */
	public function sendEvent($event, $params = array()){
		
		if(isset ($this->actions[$event])){
			foreach ($this->actions[$event] as $eventO){
				$eventO->doEvent($params);
			}
		}
	}
	
}

?>
