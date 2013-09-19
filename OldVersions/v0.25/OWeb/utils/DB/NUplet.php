<?php


namespace OWeb\utils\DB;

/**
 * Description of NUplet
 *
 * @author De Cramer Oliver
 */
class NUplet{
	
	function __construct($data) {
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function __get($nom) {
		if(isset($this->$nom))
			return $this->$nom;
		else
			throw new \OWeb\Exception ("Collone \"$nom\" inexsistante dans la table : ");
	}
}

?>
