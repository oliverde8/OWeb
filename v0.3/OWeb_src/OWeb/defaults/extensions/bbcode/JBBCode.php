<?php

namespace Extension\bbcode;
/**
 * Description of JBBCode
 *
 * @author oliverde8
 */
class JBBCode extends \OWeb\types\Extension{
	
	private $parser = null;
	
	protected function init() {
		
	}
	
	protected function getNewParser(){
		$parser = new JBBCode\Parser();
		if($this->parser == null)
			$this->parser = $parser;
		
		$parser->addCodeDefinition(new \Extension\bbcode\JBBCode\myCodes\Titles());
		
		return $parser;
	}
	
	public function getParser(){
		return $this->parser == null ? $this->getNewParser() : $this->parser;
	}
}

?>
