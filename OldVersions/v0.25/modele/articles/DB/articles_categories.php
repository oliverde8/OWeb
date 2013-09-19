<?php

namespace modele\articles\DB;

/**
 *
 * @author De Cramer Oliver
 */
class articles_categories extends \OWeb\utils\DB\Table{
	
	function __construct(\Extension\DB\connection $ext_connection) {
		parent::__construct($ext_connection);
		$this->add_clePrimaire("Id_categorie");
	}
}

?>
