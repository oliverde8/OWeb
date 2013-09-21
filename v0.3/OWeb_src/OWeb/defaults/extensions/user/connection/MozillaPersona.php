<?php

namespace Extension\user\connection;

/**
 * Description of MozillaPersona
 *
 * @author oliverde8
 */
class MozillaPersona extends SimpleConnection{

	protected function connect_new($login, $pwd) {				
		$persona = new \Extension\user\connection\MozillaPersona\Persona();

		$result = $persona->verifyAssertion($pwd);

		if ($result->status === 'okay') {

            $this->email = $result->email;

            //We connected need to check if first connection or if user already connected
            $NewPwd = $this->getMailPwd($this->email);

            if($NewPwd){
                //Not first connection let's rock and roll the connection
                $this->createCookies($this->login, $NewPwd);
                return true;
            }else{
                //Oups new connection this is more complicated. The user doesen't yet have a Login.
                // @TODO better login handling.
                //We will just use mail as login, user might change it later.
                $connection = $this->ext_db_absConnect->get_Connection();
                $prefix = $this->ext_db_absConnect->get_Prefix();


                $sql = $connection->prepare("INSERT INTO ".$prefix."users(Login, pwd, e-mail) VALUES(:mail, :pwd, :mail)");
                $sql->execute(array(':mail'=>$this->email, ':pwd'=>$this->createkey(30)));
            }

			return true;
		} else {
			return false;
		}
	}

}

?>
