<?php

namespace Extension\utilisateur\permission;

use OWeb\Type\Extension;

/**
 * Description of simple
 *
 * @author De Cramer Oliver
 */
class simple_DBConnection extends Extension{
	
	private $utilisateurs=array();
	private $ext_utilisateur;
	
	protected function init() {
		$this->ajoutDepandence('DB\connection');
		
		//$reglages = $this->chargerReglages();
	}
	
	protected function get_permissions($login){
		
		$connection = $this->ext_DB_connection->get_Connection();
		
		$sql = $connection->query("SELECT nom_permission, donnerPermission
							FROM ".PREFIX."permissions P, ".PREFIX."permission_uti PU
							WHERE login='".$login."'
								AND P.Id_Permission=PU.Id_Permission");
		$permission["a"]=array();
		$permission["d"]=array();
		
		$sql = $sql->fetchAll();
		
		foreach($sql as $sqlr){
			$permission["a"][$sqlr["nom_permission"]]=true;
			if($sqlr["donnerPermission"])$permission["d"][$sqlr["nom_permission"]]=true;
		}
		$this->utilisateurs[$login] = $permission;
	}

	//Controle si on a la permission ou pas
	public function hasPermission($login, $p){
		$ext_utilisateur = \Extension\utilisateur\connection\TypeConnection::getInstance();
		if(!$$ext_utilisateur->isConnected()){
			return false;
		}else{
			return (isset($this->utilisateurs[$login][$p])&&$this->utilisateurs[$login][$p]);
		}
	}

	public function canGivePermission($login, $p){
		$ext_utilisateur = \Extension\utilisateur\connection\TypeConnection::getInstance();
		if(!$$ext_utilisateur->isConnected())return false;
		else{
			return (isset($this->utilisateurs[$login][$p])&&$this->utilisateurs[$login][$p]);
		}
	}
	
	public function I_hasPermission($p){
		$ext_utilisateur = \Extension\utilisateur\connection\TypeConnection::getInstance();
		return $this->hasPermission($ext_utilisateur->getLogin(), $p);
	}

	public function I_canGivePermission($p){
		$ext_utilisateur = \Extension\utilisateur\connection\TypeConnection::getInstance();
		return $this->canGivePermission($ext_utilisateur->getLogin(), $p);
	}
}

?>
