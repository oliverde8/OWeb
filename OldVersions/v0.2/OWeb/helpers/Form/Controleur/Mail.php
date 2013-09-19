<?php

namespace OWeb\helpers\Form\Controleur;


/**
 * Le Controleur de Forumulaire qui controle si un mail en est bien un
 *
 * @version 1.0
 * @author oliver
 */
class Mail extends Controleur{


    const ERREUR_HOST = 'Erreur_Host';
    const ERREUR_CARACTERE_INVALIDE = 'Erreur_Caractere_Invalide';
    /**
     *
     * @param <String> $mail Le mail a controler
     * @return <int> 0 si le mail est correcte. Voir les constantes pour les autres erreures
     */
    static public function controler($mail, $params=""){
        $pattern = "/^[\w-]+(\.[\w-]+)*@";
        $pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";

        if (preg_match($pattern, $mail_address)) {
            $parts = explode("@", $mail_address);
            if (checkdnsrr($parts[1], "MX")){
                return false;
            } else {
                return self::ERREUR_HOST;
            }
        }else {
            return self::ERREUR_CARACTERE_INVALIDE;
        }
    }

    /**
     *
     * @param <type> $erreur Le nom ou le numero d'erreur
     * @return string Le Message d'erreur. Renvoie Faux si l'erreur demande n'existe pas
     */
    static public function get_MessageErreur($erreur){

        if(!isset($this->msgErreures[self::ERREUR_HOST]))
                $this->msgErreures[self::ERREUR_HOST] = \OWeb\Gerer\Langue::getText("OWeb\helpers\Form\Controleur\Mail", self::ERREUR_HOST);
        
        if(!isset($this->msgErreures[self::ERREUR_CARACTERE_INVALIDE]))
                $this->msgErreures[self::ERREUR_CARACTERE_INVALIDE] = \OWeb\Gerer\Langue::getText("OWeb\helpers\Form\Controleur\Mail", self::ERREUR_CARACTERE_INVALIDE);

        if(isset($this->msgErreures[$erreur]))
            return $this->msgErreures[$erreur];
        else
            return false;
    }

}
?>
