<?php

namespace Extension\user\connection;

/**
 * Description of TypeConnection
 *
 * @author De Cramer Oliver
 */
abstract class TypeConnection extends \OWeb\types\Extension{
	
	const TYPE_NEW = 1;
	const TYPE_SESSION = 2;
	const TYPE_COOKIE = 3;
	
	private $settings;
	
	protected $set_CookieTime;
	protected $set_SessionName = 'OWeb_Session025';
	
	protected $lang;
	
	protected $isConnected = false;
	protected $connection_type = 0;
	
	
	protected function init() {
		
		$this->settings = $this->loadSettings();
		
		//Cokie Time Setting
		if(!isset($this->settings['CookieTime']))
			$this->set_CookieTime = (3600 * 24 * 7 * 4);
		else
			$this->set_CookieTime = (int)$this->settings['CookieTime'];
		
		//Session Name
		if(!isset($this->settings['SessionName']))
				$this->set_SessionName = 'OWeb_Session025';
		else
			$this->set_SessionName = $this->settings['SessionName'];
		
		$this->isConnected = $this->startConnection();
	}
	
	
	protected function startConnection() {
		
		$get = \OWeb\OWeb::getInstance()->get_get();
		$post = \OWeb\OWeb::getInstance()->get_post();
		$cookies = \OWeb\OWeb::getInstance()->get_cookies();
		
		session_name($this->set_SessionName);
		session_start();
		
		
		if(isset($get['ext_a']) && $get['ext_a'] == 'disconnect'){
			$this->disconnect();
			$this->getLandDisConnected($get, $cookies);
			return false;
		}
		
		//If we have login information in the session let's try to connect;
		if(isset($_SESSION[$this->set_SessionName.'_auth'])){
			$result = explode(":",$_SESSION[$this->set_SessionName.'_auth']);
			if(sizeof($result) > 1)
				if($this->connect_session($result[0], $result[1])){
					$_SESSION[$this->set_SessionName.'_auth']=$result[0].":".$result[1];
					$this->connection_type = self::TYPE_SESSION;
					$this->getLangConnected($get, $cookies);
					return true;			
				}
		}
		
		//Well let's se with the cookes then
		if(isset($cookies[$this->set_SessionName.'_auth']) 
				&& isset($cookies[$this->set_SessionName.'_auth']['login'])
				&& isset($cookies[$this->set_SessionName.'_auth']['pwd']))
			if($this->connect_cookie($cookies[$this->set_SessionName.'_auth']['login']
					, $cookies[$this->set_SessionName.'_auth']['pwd'])){
				$this->connection_type = self::TYPE_COOKIE;
				$this->getLangConnected($get, $cookies);
				return true;
			}
		
			
		//Still nothing. Maybe a new connection?
		if(isset($post['ext_a']) && $post['ext_a'] == 'connect' && isset($post['login']) && isset($post['pwd']))
			if($this->connect_new ($post['login'], $post['pwd'])){
				$_SESSION[$this->set_SessionName.'_auth']=$post['login'].":".md5($post['pwd']);
				$this->connection_type = self::TYPE_NEW;
				$this->getLangConnected($get, $cookies);
				return true;
			}
		
		$this->getLandDisConnected($get, $cookies);
		return false;
	}
	
	public function isConnected(){
		return $this->isConnected;
	}
	
	protected abstract function getLangConnected($get, $cookie);
	
	protected function getLandDisConnected($get, $cookies){
		if(isset($get['lang']) 
				&& (strlen($get['lang'])>=2 ) 
				&& $this->lang != $get['lang']){
			$this->lang = $get['lang'];
			setcookie($this->set_SessionName."_auth[lang]", $this->lang);
			
		}else if(isset($cookies[$this->set_SessionName.'_auth']['lang'])){
			$this->lang = $cookies[$this->set_SessionName.'_auth']['lang'];
		}else{
			$this->lang = $this->getDefaultLanguage();
		}
	}
	
	public function getDefaultLanguage(){
		$settings = \OWeb\manage\Settings::getInstance()->getSetting('OWeb\types\Language');
		return $settings['default_language'];
	}
	
	public function disconnect(){
		session_destroy();
		setcookie($this->set_SessionName."_auth[login]");
		setcookie($this->set_SessionName."_auth[pwd]");
	}
	
	public function getConnectionType(){
		return $this->connection_type;
	}
	
	public function getLang(){
		return $this->lang;
	}
	
	public abstract function getLogin();
	
	protected abstract function connect_session($login, $pwd);
	
	protected abstract function connect_cookie($login, $pwd);
	
	protected abstract function connect_new($login,$pwd);
}

?>
