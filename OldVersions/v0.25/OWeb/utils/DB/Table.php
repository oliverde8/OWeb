<?php

namespace OWeb\utils\DB;

/**
 *
 * @author De Cramer Oliver
 */
abstract class Table extends \OWeb\utils\Singleton{
	
	private $table_name; 
	private $nuplet_class;
	
	private $ext_connection;
	
	private $clePrimaires = array();
	private $data = array();
	
	function __construct(\Extension\DB\connection $ext_connection) {
		$this->ext_connection = $ext_connection;	
		
		$name = explode("\\", get_class($this));
		$this->table_name = $name[sizeof($name)-1];
		
		$this->nuplet_class = "";
		for($i=0; $i<sizeof($name)-1; $i++ ){
			$this->nuplet_class.="\\".$name[$i];
		}
		$this->nuplet_class.="\\NUplet_".$this->table_name;
	}

	protected function add_clePrimaire($nom){
		$this->clePrimaires[] = $nom;
	}
	
	public function get_all($start = NULL, $nbElem = 10, $order = NULL){
		
		$connection = $this->ext_connection->get_Connection();
		
		if($order != NULL)
			$order = "ORDER BY ".$order;
		
		$limit = "";
		if($start != NULL)
			$limit = "LIMIT $start , $nbElem ";
			
		$sql = "SELECT * 
					FROM ".$this->table_name." ".$limit." ".$order;
		
		if($sql = $connection->query($sql))
			return $this->gerer_ResultatRequete($sql);
		else
			echo "erroooor";
	}
	
	
	public function gerer_ResultatRequete($requete){
		
		if($requete->rowCount() > 0){		
			$toreturn = array();
			$resultat = $requete->fetchAll();
			
			$i = 0;
			foreach ($resultat as $val){
				$key = "";
				foreach($this->clePrimaires as $pkey)
					$key = "_".$val[$pkey];
				
				if(isset($this->data[$key]))
					$toreturn[$i] = $this->data[$key];
				else
					$toreturn[$i] = new $this->nuplet_class($val);
				
				$i++;
			}
			return $toreturn;
		}
		else{
			return array();
		}
		
		
		
	}
	
	
}

?>
