<?php

namespace Extension\db;

/**
 * Description of Connection
 *
 * @author De Cramer Oliver
 */
class Connection extends absConnect{

	
	protected function init() {
		
	}
	
	/*
	 * Creates a connection
	 */
	protected function startConnection() {
		
		$this->reglages = $this->loadSettings();
		$this->prefix = $this->reglages['prefix'];
		
		$con = $this->reglages['connection.type'] . ':host=' . $this->reglages['connection.host'] . ';dbname=' . $this->reglages['connection.dbname']."";
		try{
			$this->connection = new \PDO($con, $this->reglages['authontification.user'], $this->reglages['authontification.password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		}catch(\Exception $ex){
			throw new \OWeb\Exception("Couldn't connect to DB : ".$con, 0, $ex);
		}
		$this->done = true;
	}
	
	public function get_Connection() {
		//Si la connection n'a pas encore ete etablis faut le faire.
		if (!$this->done)
			$this->startConnection();
		return $this->connection;
	}
	
}

?>
