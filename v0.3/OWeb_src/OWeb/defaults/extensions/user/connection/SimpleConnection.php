<?php

namespace Extension\user\connection;

/**
 * Description of SimpleConnection
 *
 * @author De Cramer Oliver
 */
class SimpleConnection extends TypeConnection{
	
	private $login;
	
	public function __construct() {
		$this->addDependance("db\absConnect");
	}
	
	protected function connect_cookie($login, $pwd) {
		return $this->checkLogin($login, $pwd);
	}

	protected function connect_new($login, $pwd) {
		if($this->checkLogin($login, md5($pwd))){
			$this->createCookies($login, $pwd);
			return true;
		}
		return false;
	}
	
	protected function createCookies($login, $pwd){
		setcookie($this->set_SessionName."_auth[login]", $login, time()+$this->set_CookieTime);
		setcookie($this->set_SessionName."_auth[pwd]", md5($pwd), time()+$this->set_CookieTime);
	}

	protected function connect_session($login, $pwd) {
		return $this->checkLogin($login, $pwd);
	}
	
	protected function checkLogin($login, $pwd){
		$connection = $this->ext_db_absConnect->get_Connection();
		$prefix = $this->ext_db_absConnect->get_Prefix();
		
		$sql = "SELECT * FROM ".$prefix."users WHERE Login = '$login' 
			AND pwd = '".$pwd."'";
		if($sql = $connection->query($sql)){
			if ($sql->rowCount()>0){
				$obj = $sql->fetchObject();
				$this->login = $obj->Login;
				$this->lang = $obj->lang;
				return true;
			}
		}
		return false;
	}
	
	protected function getLangConnected($get, $cookie){
		if($this->getConnectionType() == self::TYPE_NEW && $this->lang != ""){
			//If there is a language defined in the cookie or the get we will ignore it
			setcookie($this->set_SessionName."_auth[lang]", $this->lang);
			
		}else if(isset($get['lang']) 
				&& (strlen($get['lang'])==2 || strlen($get['lang'])==2) 
				&& $this->lang != $get['lang']){
			$this->lang = $get['lang'];
			//Updating in Database 
			$this->updateLangDB();
			
			//Updating in Cookies
			setcookie($this->set_SessionName."_auth[lang]", $this->lang);
			
		}else if(isset($cookies[$this->set_SessionName.'_auth']['lang'])
				&& $cookies[$this->set_SessionName.'_auth']['lang'] != $this->lang){
			$this->lang = $cookies[$this->set_SessionName.'_auth']['lang'];
			//Well updating Database again
			$this->updateLangDB();
		}

	}
	
	private function updateLangDB(){
		$connection = $this->ext_db_absConnect->get_Connection();
		$prefix = $this->ext_db_absConnect->get_Prefix();

		$statement = $connection->prepare('UPDATE '.$prefix.'users SET lang = :lang WHERE Login = \''.$this->login."'");
		$statement->execute(array(':lang' => $this->lang));
	}

	public function getLogin() {
		if($this->isConnected())
			return $this->login;
		else
			return "";
	}
}

?>
