<?php
/**
 * Effectuer les controle necessaire pour les formulaires.
 *
 * @package OWeb lib Form
 * @version 1.0
 * @author oliver
 */
class OWeb_helpers_Form_Controleur {

    private $class;
    private $fonction;

    private $params;
    private $text;

    private $y_erreur = false;
    private $erreur = 0;
    /**
     * Permet d'utiliser votre propre form contoller
     *
     * @param <type> $class Le nom de la class qui va gerer le controle
     * @param <type> $fonction_controle Le nom de la fonction dans la classe qui va gerer le controle
     * @param <type> $fonction_getErreur Le nom de la fonction qui va envoyer les messages d'erreures erreures.
     * @param <type> $params Les parametres a passer au controleur
     * @param <type> $msg_erreures La liste des messages d'erreures, si vous voulez les remplacer par vos propes messages
     */
    public function __construct($class, $fonction_controle, $fonction_getErreur, $params=null, $msg_erreures=null){

        $this->class = $class;
        $this->fonction = $fonction;
        $this->erreur_fonc=$fonction_getErreur;
        $this->text = $msg_erreures;
    }

    /**
     *
     * @param <type> $nom Le nom du controlleur par default a utiliser
     * @param <type> $params Les parametres a passer au controleur
     * @param <type> $msg_erreures Les messages d'erreure, si on veut changer ceux par default
     */
    public function __construct($nom, $params=null,$msg_erreures=null){

        $this->fonction="controler";
        $this->erreur_fonc="get_MessageErreur";

        $this->class = "OWeb_helpers_Form_Controleur_".$nom;

        if(!OWeb_Main_AutoLoader::charger($this->class)){
             throw new OWeb_Exception("Le controleur de formulaire demande '".$nom."' n'existe pas");
        }
    }

    public function controler(){

        $this->erreur = call_user_func(array($this->class, $this->fonction), $this->params);

        if($this->erreur != 0){
            $this->y_erreur=true;
        }
    }

    /**
     *
     * @return <Boolean> Si oui ou non la valeur est valide
     */
    public function yErreur(){
        return $this->y_erreur;
    }

    /**
     *
     * @return <type> Retourne le nom ou le numero de l'erreur si il'y en a  une
     */
    public function get_Erreur(){
        return $this->erreur;
    }

    public function get_MessageErreur($num=null){
        
        if($num == null)
            $num = $this->erreur;

        if(isset($this->text[$num]))
            return $this->text[$num];
        else 
            return call_user_func(array($this->class, $this->erreur_fonc), $num);
    }

}
?>
