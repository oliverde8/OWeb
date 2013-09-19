<?php

namespace OWeb\helpers\Form\Controleur;

/**
 * Le Controleur de Forumulaire qui controle si un mail en est bien un
 *
 * @package OWeb lib Form
 * @author oliver
 */
abstract class Controleur {

    private $erreur = null;

    protected $msgErreures;

    abstract static function controler($in, $params);

     /**
     * Permet de recuperer le message d'erreur qui va avec une erreur
     * 
     * @param <type> $erreur Le nom ou le numero d'erreur
     * @return string Le Message d'erreur. Renvoie Faux si l'erreur demande n'existe pas
     */
    abstract function get_MessageErreur($erreur);

    public function setErreur($erreur){
        $this->erreur = $erreur;
    }

    public function getErreur(){
        return $this->erreur;
    }

    public function yErreur(){
        if($this->erreur==null)
            return false;
        else
            return true;
    }

    public function setMsgErreur($erreur, $msg){
        $this->msgErreures[$erreur]=$msg;
        return $this;
    }

    public function setMsgsErreur(Array $msgs){
        foreach ($msgs as $erreur => $msg) {
            $this->msgErreures[$erreur]=$msg;
        }
    }

}
?>
