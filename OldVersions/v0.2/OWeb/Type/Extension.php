<?php

namespace OWeb\Type;

use OWeb\OWeb;
use OWeb\Gerer\Erreurs;
use OWeb\Gerer\Reglages;
use OWeb\Gerer\Evenments;

use OWeb\Types\Depandence;
/**
 * Description of extension
 *
 * @author De Cramer Oliver
 */
abstract class Extension {

    protected $gereur_erreurs;
    protected $OWeb;
    protected $dir;

    //Carateristique de l'Extension
    private $_nom;
    private $_auteur;
    private $_version;
    private $_description;
    private $_website;

    //d
    private $actions;
    private $evenments;
    private $dependence;

    //Etapes
    private $OWeb_init = false;

    function __construct(OWeb &$oweb,
                            Erreur &$erreures, $dir) {
        
	$this->_nom = get_class($this);
	$this->_description = 'no Description';
        
        $this->gereur_erreurs = $erreures;
        $this->gereur_reglages = $reglages;
        $this->gereur_extension = $extension;
        $this->OWeb = $oweb;
        $this->dir = $dir;
        
        $this->init();
    }



    abstract protected function init();

    public function OWeb_Init(){  
        if(!empty($this->dependence)){
            foreach ($this->dependence as $dep){
                $ext = $this->gereur_extension->getExtension($dep->name);
                if(!$ext){
                     $this->gereur_erreurs->ajoutErreur("OWeb/types/extension.php",
                                                    "OWeb_Init",
                                                    "Impossible de charger l'extension : ".$dep->name,
                                                    "L'extention ".$this->nom." EN a basoin pour fonctionner",
                                                    Erreur::$critic);
                }else{
                    $name = "ext_".$dep->name;
                    $this->$name = $ext;
                }
            }
        }
    }

    /**********************************************
        Les fonction Protected
    *********************************************/
    protected function set_Auteur($auteur) {
	$this->_auteur = $auteur;
    }

    protected function set_Version($in_version) {
	$this->_version = $in_version;
    }

    protected function set_Description($desc) {
	$this->_description = $desc;
    }

    protected function set_Website($web) {
	$this->_website = $web;
    }

    public function add_Evenment($Nomevent,$fonction){
        Evenments::addEvenment($Nomevent, $this, $fonction);
    }

    protected function chargerReglages($fichier = ""){
        if($file == "")
            return Reglages::chargerReglage($this, $fichier);
    }

    protected function ajoutDepandence($plugin_name, $min_ver = null, $max_ver = null) {
            $this->dependence[] = new Depandence($plugin_name, $min_ver, $max_ver);
    }

    /**********************************************
        Les fonction Public
     *********************************************/
    public function get_Auteur(){
        return $this->_auteur;
    }

    public function get_Version(){
        return $this->_version;
    }

    public function get_Description(){
        return $this->_description;
    }

    public function get_WebSite(){
        return $this->_website;
    }

}
?>
