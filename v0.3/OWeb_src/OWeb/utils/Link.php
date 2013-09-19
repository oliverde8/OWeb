<?php

namespace OWeb\utils;

/**
 * Description of Link
 *
 * @author De Cramer Oliver
 */
class Link {
	
	private static $currentLink = null;
	
	
	private $generator = null;
	private $params = array();
	
	function __construct($params=array(), \OWeb\utils\link\Generator $generator=null) {
		$this->params = $params;
		if($generator == null)
			$this->generator = new \OWeb\utils\link\Default_generator();
		else
			$this->generator = $generator;
	}

	public function removeParam($paramName){
		if(isset($this->params[$paramName]))
			unset($this->params[$paramName]);
		return $this;
	}
	
	public function addParam($paramName, $value){
		$this->params[$paramName] = $value;
		return $this;
	}
	
	public function __toString() {
		return $this->generator->generate_LinkString($this->params);
	}
	
	public static function getCurrentLink($generator=null){
		if(self::$currentLink != null)
			return self::$currentLink;
		else{
			return new Link(\OWeb\OWeb::getInstance()->get_get(), $generator);
		}
	}
}

?>
