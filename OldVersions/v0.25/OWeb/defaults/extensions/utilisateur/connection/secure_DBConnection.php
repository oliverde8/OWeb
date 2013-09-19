<?php

namespace Extension\utilisateur\connection;

/**
 * Description of simple_DBConnection
 *
 * @author De Cramer Oliver
 * @todo 
 *		- !Gerer mieux les erreures
 *		- Effacer les donnees sur les ancien adresse IP
 */
class secure_DBConnection extends TypeConnection {

	private $connection;
	protected $set_maxNbEssai;

	protected function init() {
		parent::init();
		$this->ajoutDepandence('DB\connection');


		$reglages = $this->chargerReglages();
		if (isset($reglages['maxNbEssai'])) {
			$this->set_maxNbEssai = $reglages['maxNbEssai'];
		} else {
			$this->set_maxNbEssai = 5;
		}
	}

	public function StartConnection() {

		$this->connection = $this->ext_DB_connection->get_Connection();
		parent::StartConnection();
	}

	protected function connectionSession($session) {
		$prefix = $this->ext_DB_connection->get_prefix();

		$sql = "SELECT * FROM " . $prefix . "users WHERE login='" . $session[0] . "'";

		if ($sql = $this->connection->query($sql)) {
			if ($sql->rowCount() > 0) {
				$res = $sql->fetchAll();
				$res = $res[0];

				if (!empty($this->lang) && $this->lang != $res['lang']) {
					$this->connection->query("UPDATE " . $prefix . "users
											SET  lang =  '" . $this->lang . "'
											WHERE  login='" . $session[0] . "'");
				} else if (empty($res["lang"])) {
					$this->connection->query("UPDATE " . $prefix . "users
												SET  lang =  'eng'
												WHERE  login='" . $sesion[0] . "'");
					$this->lang = 'eng';
				} else {
					$this->lang = $res["lang"];
				}
				$this->loginDone($session[0], false);
				return true;
			}
		}
		return false;
	}

	protected function connectionCookie($cookie) {
		$login = $cookie['login'];
		$mdp = $cookie['mdp'];
		if ($this->loginSafeCheck($login, $mdp)) {
			$this->loginDone($login, false);
			return true;
		}
	}

	protected function nouvelleConnection($post) {
		$login = $post['login'];
		$pwd = $post['mdp'];
		$prefix = $this->ext_DB_connection->get_prefix();

		if ($this->loginCheck($login, md5($pwd))) {
			$this->loginDone($login, true);
			return true;
		}
		return false;
	}

	protected function loginCheck($login, $pwd, $new = true, $pwdField = 'mdp') {
		$prefix = $this->ext_DB_connection->get_prefix();
		$sql = "SELECT *
				FROM " . $prefix . "users u, " . $prefix . "users_Security us
				WHERE u.login = us.login
					AND us.user_Ip = '" . $this->OWeb->getAdresseVisiteur() . "'
					AND u.login='" . $login . "'";

		if ($sql2 = $this->connection->query($sql)) {
			if (!($sql2->rowCount() > 0)) {
				if($new){
					//2 possibilite, Login est Faux, ou premiere tentative.
					$sql3 = "SELECT *
							FROM " . $prefix . "users
							WHERE login='" . $login . "'";

					if ($sql4 = $this->connection->query($sql3)) {
						if ($sql4->rowCount() > 0) {
							$this->connection->query("INSERT INTO users_Security(`login`,`user_Ip`)
														VALUES('$login', '" . $this->OWeb->getAdresseVisiteur() . "')");
							echo "INSERT INTO users_Security(`login`,`user_Ip`)
														VALUES('$login', '" . $this->OWeb->getAdresseVisiteur() . "')";
							$sql2 = $this->connection->query($sql);
						} else {
							throw new Exception("Login inconnu");
							return false;
						}
					}
				}else{
					return false;
				}
			}


			$res = $sql2->fetchAll();
			$res = $res[0];

			if ($res['nbTries'] >= $this->set_maxNbEssai
					&& $res['lastTryDate'] > (time() - ( ($res['nbTimesBlocked'] + 1) * 3600) )) {
				throw new Exception("Vous avez esseyer de vous connecter " . $res['nbTries'] . " fois. " .
						"Vous devez resseyer plus Tard");
				return false;
			} else {
				//On peut retenter un login.
				if ($pwd == $res[$pwdField]) {
					return true;
				} else {
					$this->loginFail($login, $this->OWeb->getAdresseVisiteur(), $res['nbTries']);
					throw new Exception("Votre Mot de Passe est FAUX");
					return false;
				}
			}
		}
	}

	protected function loginSafeCheck($login, $pwd) {
		if(!$this->loginCheck($login, $pwd, false, 'securityCode')){
			return false;
		}else return true;
	}

	protected function loginDone($login, $update) {
		$this->login = $login;
		$this->connected = true;
		$prefix = $this->ext_DB_connection->get_prefix();
		$cookie = $this->OWeb->GetCookie();

		setcookie($this->set_SessionName."_auth[login]", $login, time()+$this->set_CookieTime);
		if($update || !isset($cookie[$this->set_SessionName.'_auth']["mdp"])){
			$key = $this->createkey(40);
			$this->connection->query("UPDATE ".$prefix."users_Security SET securityCode='".$key."' WHERE login='".$login."'");
			setcookie($this->set_SessionName."_auth[mdp]", $key, time()+$this->set_CookieTime);
		}else{
			setcookie($this->set_SessionName."_auth[mdp]", $cookie[$this->set_SessionName.'_auth']["mdp"], time()+$this->set_CookieTime);
		}
	}

	protected function loginFail($login, $ip, $nbEssai) {
		$nbEssai++;
		$prefix = $this->ext_DB_connection->get_prefix();
		if ($nbEssai >= $this->set_maxNbEssai) {
			$this->connection->query("UPDATE " . $prefix . "users_Security
											SET  nbTries = 0
												,lastTryDate = " . time() . "
													,nbTimesBlocked = nbTimesBlocked + 1
											WHERE  login = '" . $login . "'
												AND user_Ip = '" . $this->OWeb->getAdresseVisiteur() . "'");
		} else {
			echo "UPDATE " . $prefix . "users_Security
												SET  nbTries = nbTries + 1
													,lastTryDate = " . time() . "
												WHERE  login='" . $login . "'
													AND user_Ip = '" . $this->OWeb->getAdresseVisiteur() . "'";
			$this->connection->query("UPDATE " . $prefix . "users_Security
												SET  nbTries = nbTries + 1
													,lastTryDate = " . time() . "
												WHERE  login='" . $login . "'
													AND user_Ip = '" . $this->OWeb->getAdresseVisiteur() . "'");
		}
	}

	private function createkey($length) {
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			switch (rand(1, 3)) {
				case 1:
					$key.=chr(rand(48, 57));
					break;
				case 2:
					$key.=chr(rand(65, 90));
					break;
				case 3:
					$key.=chr(rand(97, 122));
					break;
			}
		}
		return $key;
	}

}

?>
