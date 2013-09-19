<?php

namespace controleur\articles;

use OWeb\Type\Controleur;
use OWeb\Gerer\enTete;

/**
 * @author Oliver
 */
class home extends Controleur {

	private $vue_deuxCollone;

	protected function init() {
		$this->vue_deuxCollone = new \sVue\deuxCollone();
		$this->addEnTete(enTete::css, "articles.css");

		$this->ajoutDepandence('DB\connection');
	}

	protected function afficher() {
		$this->vue->vue_deuxCollone = $this->vue_deuxCollone;

		$this->connection = $this->ext_DB_connection->get_Connection();
		
		
		$articles = new \modele\articles\DB\articles_categories($this->ext_DB_connection);
		$all = $articles->get_all();
	}

}

?>
