<?php

namespace Extension\db;

/**
 * Description of absConnect
 *
 * @author De Cramer Oliver
 */
abstract class absConnect extends \OWeb\types\Extension{
	
	protected $connection;
	protected $done = false;
	protected $prefix;
	
	abstract public function get_Connection();
	
	public function get_prefix(){
		return $this->prefix;
	}
	
}

?>
