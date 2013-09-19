<?php

namespace OWeb\helpers\Form;

use OWeb\Exception;

use OWeb\helpers\Form\Element;
use OWeb\Gerer\Evenments;
use OWeb\Gerer\enTete;

/**
 * Permet de Creer des formulaires tres facilement
 * 
 * @author oliver De Cramer
 */
abstract class Form{

    /* Les Constantes */
    const METHOD_DELETE = 'delete';
    const METHOD_GET    = 'get';
    const METHOD_POST   = 'post';
    const METHOD_PUT    = 'put';

    protected $OWeb;


    private $page;
    private $methode;
    private $codeAction;

    private $nb_element;
    private $elements = array(); //Les elements formont le formulaires
    private $id;

    static $nbForms = 0;

    private static $css;
    private static $js;

    private $controler=false;

    private $actionControler=false;

    /**
     */
    public function __construct(OWeb $OWeb, $methode="", $page=null, $trigger="action", $triggerValue=null){
        if($methode != self::METHOD_DELETE
                && $methode != self::METHOD_GET
                && $methode != self::METHOD_POST
                && $methode != self::METHOD_PUT){
            throw new Exception("Methode inconnue pour le formulaire");
        }
        
        $this->methode = $methode;
        $this->page = $page;
        $this->nb_element = 0;

        $this->OWeb = $OWeb;

        $this->id = self::$nbForms;
        self::$nbForms++;

        self::$css = OWEB_DIR_MAIN.'/defaults/sources/css/Helpers_Form.css';
        self::$js = OWEB_DIR_MAIN.'/defaults/sources/js/Helpers_Form/Description.js';

        Evenments::addEvenment("AffciherEnTete@OWeb", $this, "preparerEnTete");

        if($this->methode == self::METHOD_GET){
            $this->creeElement("controleur", "", "hiden")->setValeur($this->page);
        }else
            $this->codeAction='action="?controleur='.$this->page.'"';
        
        if($triggerValue==null){
            $val=explode("\\",  \get_class ($this));

            $triggerValue=$val[sizeof($val)-1];
        }
        
        $get = $this->OWeb->GetGet();
        if(isset($get[$trigger]) && $get[$trigger]==$triggerValue){
            $this->controler=true;
        }else{
            $get = $this->OWeb->GetPost();
            if(isset($get[$trigger]) && $get[$trigger]==$triggerValue)
                $this->controler=true;
        }

        if($trigger!=null)
            $this->creeElement($trigger, "", "hiden")->setValeur($triggerValue);

        $this->init();
    }

    public function preparerEnTete(){

        if(self::$css)
            enTete::ajoutEnTete(enTete::css, self::$css);
        if(self::$js)
            enTete::ajoutEnTete(enTete::javascript, self::$js);

        foreach($this->elements as $el){
            $el->preparer();
            $el->preparerEnTete();
        }
    }

    protected abstract function init();

    /**
     * @brief Cree un Element de formulaire
     *
     * @param <type> Le id unique
     * @param <type> Le type d'Element
     * @param <type> $controleur Est une array de controle qu'il faut effectuer.
     * @param <type> $options
     * @return <type> l'element de form cree
     */
    protected function creeElement($name, $text, $type, $controleurs = array(), $options = array()){
        /*La valeur de l'element */
        $valeur = $this->getValeur($name);

        $class = "OWeb\helpers\Form\Element\\".$type;
        $this->elements[$this->nb_element] = new $class($name, $text, $valeur);
        $this->nb_element++;

        foreach($controleurs as $ctr){
            $this->elements[$this->nb_element]->ajouter_controleur($ctr);
        }

        return $this->elements[$this->nb_element-1];
    }

    /**
     * @brief Permet d'ajouter des element OWeb_helpers_Form_Element
     * @param OWeb_helpers_Form_Element Ajouter un Element de Formulaire
     */
    protected function ajoutElement(Element $element){

        $this->elements[$elemen->getId()] = $element;
        $this->nb_element;
    }

    /**
     *
     * @param <type> Le nom de la valeur passer en parametre ou site
     * @return <type> La Valeur demande
     */
    protected function getValeur($nom){

        if($this->methode == self::METHOD_GET)
            $get = $this->OWeb->GetGet();
        else if($this->methode == self::METHOD_POST)
            $get = $this->OWeb->GetPost();
        else
            $get = $this->OWeb->GetGet();

        if(isset($get[$nom]))return $get[$nom];
        else return "";
    }

    public function controler(){
        if($this->actionControler)
            return;

        $erreurs=array();
        foreach($this->elements as $el){
            $erreurs[] = $el->controler();
        }
        $this->actionControler=true;
        return $erreurs;
    }


    public function __toString(){

        if($this->controler)
            $this->controler();
        
        $html="";
        $html.="\n".'<form class="OWebForm" method="'. $this->methode.'"  >'."\n";
        
        foreach($this->elements as $el){
            $html .= $el->renderHtml($this->controler);
        }

        $html.='</form>'."\n";
        return $html;
    }

    public function estValide(){
        $this->controler();
        foreach($this->elements as $el){
            if($el->yErreur())
                return false;
        }
        return true;
    }
}
?>
