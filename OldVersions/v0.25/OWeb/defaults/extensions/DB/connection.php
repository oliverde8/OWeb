<?php

namespace Extension\DB;

use OWeb\Type\Extension;

/**
 * Cette class permet de ce connecter a une BD
 * La connection a la BD sera effectuer uniquement si necessaire.
 *
 *  - Element de Configuration -
 *      [Extension\DB\connection]
 *           connection.type = mysql
 *           connection.host = localhost
 *           connection.dbname = oliverde8
 *           authontification.user = root
 *           authontification.password =
 * 
 * @author Oliver de Cramer
 */
class connection extends Extension {

	private $connection;
	private $etabli = false;
	private $reglages;
	private $prefix;

	/**
	 * L'initialisation de l'extension
	 */
	protected function init() {
		//On charge les reglages de cete Extension.
		$this->reglages = $this->chargerReglages();
		$this->prefix = $this->reglages['prefix'];
	}

	/*
	 * Etablie une connection 
	 */

	protected function startConnection() {

		$con = $this->reglages['connection.type'] . ':host=' . $this->reglages['connection.host'] . ';dbname=' . $this->reglages['connection.dbname'].";charset=UTF-8";

		$this->connection = new \PDO($con, $this->reglages['authontification.user'], $this->reglages['authontification.password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		$this->etabli = true;
	}

	/*
	 * Retourne la connection PDO.
	 */

	public function get_Connection() {
		//Si la connection n'a pas encore ete etablis faut le faire.
		if (!$this->etabli)
			$this->startConnection();
		return $this->connection;
	}

	public function get_prefix(){
		return $this->prefix;
	}

}

?>
