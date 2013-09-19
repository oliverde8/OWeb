<?php

/**********************************************************************************
* src/oweb.php
* OWeb main File to get it run
***********************************************************************************
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
***********************************************************************************
* OWeb is a simple Object PHP FrameWork
* ===============================================================================
* Version:		              0.2.0a
* Author	                  Oliver de Cramer (oliverde8 at gmail.com)
**********************************************************************************/

namespace OWeb;

define("OWEB_VERSION", "0.2.0a");

//La classe qui gere les erreurs
require_once OWEB_DIR_MAIN.'/gerer/Erreurs.php';

//La classe qui gere les erreurs
require_once OWEB_DIR_MAIN.'/gerer/Reglages.php';

//La classe gui gere les controleurs
require_once OWEB_DIR_MAIN.'/gerer/Controleurs.php';

//La calsse qui gere les Extensions
require_once OWEB_DIR_MAIN.'/gerer/Extensions.php';

require_once OWEB_DIR_MAIN.'/gerer/Evenments.php';

//La classe qui inclu automatiquement toutes les autre class
require_once OWEB_DIR_MAIN.'/autoLoader.php';


//Une fois le AutoLoader intantier on a plus besoin de faire des require.
//Le autoloader va charger toutes les autres classes necessaires

class OWeb {
    
    //Les variables contenant les tableaux associatifs des valeurs passées au script courant via les paramètres d'URL.
    private $_get;
    private $_post;
    private $_files;
    private $_server;

    private $gereur_Erreurs;       //Classe qui gere les erreurs

    private $initialiser = false;   //Fait savoir sil OWeb a ete initialiser ou pas

    public function __construct(&$get,&$post, &$files, &$server) {

        //Initialiser le gerreur d'erreurs
        $this->gereur_Erreurs = new Gerer\Erreur();

        //A partir de maintenant si il'y une erreur c'est a OWeb de le gerer
        set_error_handler(array($this->gereur_Erreurs,"gestion_Erreur"));

        //Et les Exception aussi sont gere par le gereur d'erreur
        set_exception_handler(array($this->gereur_Erreurs,"gestion_Exception"));

        //Si il'y a une erreur fatale on va aussi gerer
        //register_shutdown_function(array($this->gereur_Erreurs,"gestion_ErreurFatale"));

        //Init Autoloader
        AutoLoader::init($this, $this->gereur_Erreurs);

        //Variables d'environement
        $this->_get= $get;
        $this->_post= $post;
        $this->_files= $files;
        $this->_server= $server;

        //Charger la configuration et tous ce qui va avec
        $this->charger_Reglages();

        Type\Modele::setgereur_extensions($this->gereur_Extensions);
    }

    private function charger_Reglages(){

        $reglage = \OWeb\Gerer\Reglages::chargerReglage($this);

		\print_r($reglage);

        //Recuperer le Debug
        if(isset($reglage["OWeb"]["debug"]))
            $debug = lib::String_to_Bool($reglage["OWeb"]["debug"]);
        else 
            $debug = false;

        $this->gereur_Erreurs->set_Debug($debug);

        //Recuperer les extensions
        if(isset($reglage["extensions"]) && !empty($reglage["extensions"])){
            $this->charger_Extensions($reglages["extension"]);
        }

    }

    private function charger_Extensions($exts){
        
        foreach($exts as $ext){
            AutoLoader::extension($ext);
        }
    }

    public function init(){
        $this->initialiser=true;

        //On charge le controleur
        $this->charger_Controleur();
        
        //On va initier les extension
        \OWeb\Gerer\Extensions::init_extensions();

        //On va initier les controleurs
        \OWeb\Gerer\Controleur::init_controleurs();

        //On fait savoir a tout le monde que OWeb est
        \OWeb\Gerer\Evenments::envoyerEvenment('Init@OWeb');
         
        //On va effectuer l'action si necessaire
        $this->faire_Action();
    }
    
    private function charger_Controleur(){
        //Voir si on un controleur est appeler et controler si celui si existe
        if(isset($this->_get["controleur"])
                &&!empty($this->_get["controleur"])
                &&AutoLoader::charger('Controleur\\'.$this->_get["controleur"]))
        {
            //On charge le controleur demande,
            $ctl = 'Controleur\\'.$this->_get["controleur"];
        }else{
            //Si on a pas specifier de controleur on charge le controleur par Default
            $ctl = 'Controleur\\'.OWEB_DEFAULT_CONTROLEUR;
        }
        
        //On initialise le controleur
        $controleur = new $ctl($this, $this->gereur_Erreurs, $this->gereur_Controleur, $this->gereur_Extensions, $this->gereur_Reglages);

        //On enregistre le controleur
        \OWeb\Gerer\Controleur::addControleur($controleur,true);
    }

    private function faire_Action(){

        //On a 2 ype d'action les action GET les action POST
        if(isset($this->_get["action"]) && !empty($this->_get["action"])){
            \OWeb\Gerer\Controleur::faire_GetAction($this->_get["action"]);

            //On envoi l'evenment
            \OWeb\Gerer\Evenments::envoyerEvenment('Action_AllDone@OWeb',array("action" => $this->_Get["action"], "type" => "get"));

        }else if(isset($this->_post["action"]) && !empty($this->_post["action"])){
            \OWeb\Gerer\Controleur::faire_PostAction($this->_get["action"]);

            //On envoi l'evenment
            \OWeb\Gerer\Evenments::envoyerEvenment('Action_AllDone@OWeb',array("action" => $this->g["action"], "type" => "post"));
        }
    }

    public function afficher($template=""){

        if($template == "")
            $this->gereur_Controleur->afficher();
        else{
            $this->loadTemplate($template);
        }
    }

    private function loadTemplate($template){
        new Template($template, $this, $this->gereur_Erreurs);
    }

    /* Cette fonction arrete OWeb*/
    public function fin(){

        /* On envoi l'evenment d'arret */
        \OWeb\Gerer\Evenments::envoyerEvenment('Fin@OWeb');
        exit;
    }


    /* Les fonction GET */
    public function GetGet(){ return $this->_get; }
    public function GetPost(){ return $this->_post; }
    public function GetFiles(){ return $this->_files; }
    public function GetServer(){ return $this->_server; }

    public function forceError(){
        /**
         * @todo Force Error
         */
    }

}

?>
