<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */
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
