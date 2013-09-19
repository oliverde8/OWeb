<?php
namespace Extension\utilisateur\connection;

use OWeb\Type\Extension;


/**
 * Description of TypeConnection
 *
 * @author De Cramer Oliver
 */
abstract class TypeConnection extends Extension{

	private $reglages;
	protected $OWeb;

	protected $set_CookieTime;
	protected $set_SessionName = 'OWeb_Session025';

	protected $lang;
	
	protected $connected;
	protected $login;

	protected function init(){
		self::forceInstance($this, 'Extension\utilisateur\connection\TypeConnection');
		//On charge les reglages de cete Extension.
        $this->reglages = $this->chargerReglages();

		if(!isset($this->reglages['CookieTime']))
			$this->set_CookieTime = (3600 * 24 * 7 * 4);
		else
			$this->set_CookieTime = (int)$this->reglages['CookieTime'];

		if(!isset($this->reglages['SessionName']))
				$this->set_SessionName = 'OWeb_Session025';
		else
			$this->set_SessionName = $this->reglages['SessionName'];
		//$this->OWeb = \OWeb\OWeb::getInstance();

		$this->add_Evenment('Loaded@OWeb', 'StartConnection');
	}

	public function StartConnection() {
		$this->OWeb = \OWeb\OWeb::getInstance();
		$post   = $this->OWeb->getPost();
		$get    = $this->OWeb->getGet();
		$cookie = $this->OWeb->GetCookie();


		session_name($this->set_SessionName);
		session_start();

		
		if(isset($get['connection']) && $get['connection']=='disconnect'){
			$this->disConnect();
		}
		
		//Checking up the language. It may be unnecessary
		$this->controleLaLangue($get, $cookie);

		$this->connected = false;
		//Checking if server remembers login?
		if(isset($_SESSION[$this->set_SessionName.'_auth'])) {
			$this->connected = $this->connectionSession(explode(":",$_SESSION[$this->set_SessionName.'_auth']));
		}
		
		if(!$this->connected && isset($post['login']) && isset($post['mdp'])){
			$this->connected = $this->nouvelleConnection($post, $_SESSION);

			$_SESSION[$this->set_SessionName.'_auth'] = $post['login'] . ":OWeb";

		}else if(!$this->connected && isset($cookie[$this->set_SessionName.'_auth'])
								&& isset($cookie[$this->set_SessionName.'_auth']["login"])
								&& isset($cookie[$this->set_SessionName.'_auth']["mdp"])
								&& !empty($cookie[$this->set_SessionName.'_auth']["mdp"])
								&& !empty($cookie[$this->set_SessionName.'_auth']["login"])){

			$this->connectionCookie($cookie[$this->set_SessionName.'_auth']);
		}
	
	}

	protected function controleLaLangue($get, $cookie){
		if(isset($get["lang"])){//Language has been changed
			$this->lang=$get["lang"];
		}else if(isset($cookie['OWeb_lang'])){//Getting ald language
			$this->lang=$cookie['OWeb_lang'];
		}else{
			$this->lang="eng"; //Default language
		}
		setcookie("OWeb_lang", $this->lang, time()+$this->set_CookieTime);
	}

	abstract protected function connectionSession($session);

	abstract protected function connectionCookie($cookie);

	abstract protected function nouvelleConnection($post);

	public function getConnectionCodeHtml(){
			 return '<form method="post" action="" />
                    <label>Login : </label>
                    <input type="text" name="login"/>

                    <label>Password : </label>
                    <input type="password" name="mdp"/>

                    <input type="submit" value="Ok" class="bouton" />
              </form>';
	}

	public function isConnected(){
		return $this->connected;
	}

	public function getLogin(){
		if($this->connected)
			return $this->login;
		return false;
	}

	public function disConnect(){
		session_destroy();
		setcookie($this->set_SessionName."_auth[login]");
		setcookie($this->set_SessionName."_auth[mdp]");
	}

}
?>
