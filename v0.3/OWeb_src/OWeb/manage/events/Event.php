<?php

namespace OWeb\manage\events;

/**
 * Description of Event
 *
 * @author De Cramer Oliver
 */
class Event {
	
	protected $object;
	protected $function;
	
	function __construct($object, $function) {
		$this->object = $object;
		$this->function = $function;
	}
	
	public function setObject($object) {
		$this->object = $object;
	}

	public function setFunction($function) {
		$this->function = $function;
	}

	public function getObject() {
		return $this->object;
	}

	public function getFunction() {
		return $this->function;
	}
	
	public function doEvent($params){
		call_user_func_array(array($this->object,$this->function),$params);
	}
	
}

?>
