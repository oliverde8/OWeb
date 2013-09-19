<?php

namespace OWeb\types;

/**
 * Describe a header to include to your page.
 *
 * @author De Cramer Oliver
 */
class header {
	
	private $code;
	private $type;
	
	
	function __construct($code, $type) {
		$this->code = $code;
		$this->type = $type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	/**
	 * Returns the string od this header.
	 * 
	 * @return type The code of the Header
	 */
	public function getCode(){

        switch($this->type){

            case \OWeb\manage\headers::javascript :
                $code = '<script type="text/javascript" src="'.$this->code.'"></script>'."\n";
                break;
            case \OWeb\manage\headers::css :
                $code = '<link href="'.$this->code.'" rel="stylesheet" type="text/css" />'."\n";
                break;
            default :
                $code = $this->code;
        }
        return $code;
    }

	
}

?>
