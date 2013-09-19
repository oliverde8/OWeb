<?php

namespace OWeb\helpers\Form\Controleur;


/**
 * Le Controleur de Forumulaire qui controle si un mail en est bien un
 *
 * @version 1.0
 * @author oliver
 */
class Date extends Controleur{


    const INVALIDE = 'PasUneDate';
    /**
     *
     * @param <String> $mail Le mail a controler
     * @return <int> 0 si le mail est correcte. Voir les constantes pour les autres erreures
     */
    static public function controler($date, $params=array()){

        if(!empty($date) && strtotime($date) === false)
            return self::INVALIDE;
        else
            return 0;

    }

    /**
     *
     * @param <type> $erreur Le nom ou le numero d'erreur
     * @return string Le Message d'erreur. Renvoie Faux si l'erreur demande n'existe pas
     */
    public function get_MessageErreur($erreur){

        if(!isset($this->msgErreures[self::INVALIDE]))
                $this->msgErreures[self::INVALIDE] = \OWeb\Gerer\Langue::getText("OWeb\helpers\Form\Controleur\Date", self::VIDE);

        if(isset($this->msgErreures[$erreur]))
            return $this->msgErreures[$erreur];
        else
            return false;
    }

}
?>
