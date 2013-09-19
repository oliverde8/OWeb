<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MozillaPersona
 *
 * @author oliverde8
 */
class MozillaPersona extends \Extension\user\connection\TypeConnection {

	protected function connect_new($login, $pwd) {				
		$persona = new \Extension\user\connection\MozillaPersona\Persona();
		
		$result = $persona->verifyAssertion($pwd);
		if ($result->status === 'okay') {
			return true;
		} else {
			return false;
		}
	}

	protected function connect_cookie($login, $pwd) {
		
	}

	protected function connect_session($login, $pwd) {
		
	}

	protected function getLangConnected($get, $cookie) {
		
	}

	public function getLogin() {
		
	}

}

?>
