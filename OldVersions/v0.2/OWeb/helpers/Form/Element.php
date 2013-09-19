<?php

namespace OWeb\helpers\Form;

/**
 * A Form element, can be an image, a hidden or else
 *
 * @author oliver
 */
abstract class Element{

    protected $name;
    protected $text;
    protected $valeur = "";
    protected $description = null;

    protected $class = null;
    protected $id = null;
    protected $num;

    protected $controleurs;
    protected $options = array();

    protected $msgErreurs;
    protected $y_erreur;

    static protected $tags = array("div");
    
    static protected $nbElement = 0;

    private $controleEffectuer = false;
    private $pre = false;

    public function __construct($name, $text, $valeur){
        $this->name = $name;
        $this->text = $text;
        $this->valeur = $valeur;

        $this->num = self::$nbElement;
        self::$nbElement++;
    }

    public function ajouter_controleur(Controleur $controleur){
        $this->controleurs[] = $controleur;
        return $controleur;
    }

    public function controler(){
        if($this->controleEffectuer)
            return;

        $erreurs = array();
        foreach($this->controleurs as $ctr){
            $erreur = $ctr->controler($this->valeur);
            if($erreur != false){
                $this->y_erreur=true;
                $ctr->setErreur($erreur);
                $this->msgErreurs[]=$ctr->get_MessageErreur($erreur);
            }
        }
        $this->controleEffectuer = true;
        return $this->msgErreurs;
    }

    /**
    *
    * @return <Boolean> Si oui ou non la valeur est valide
    */
    public function yErreur(){
        return $this->y_erreur;
    }

    /**
     * Afficje l^'element
     */
    abstract public function renderHtml($afficherErreur=false);

    abstract public function preparerEnTete();

    public function preparer(){
        if($this->pre)
            return ;

        if($this->id == null)
            $this->id = $this->num;

        if($this->class == null)
            $this->class = ' OWebForm';
        else
            $this->class = ' '.$this->class;

        $this->pre = true;
    }

    public function getId(){
        $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getValeur() {
        return $this->valeur;
    }

    public function setValeur($valeur) {
        $this->valeur = $valeur;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }



}
?>
