<?php

/**********************************************************************************
* OWeb\OWeb.php
* OWeb main File to get it run
***********************************************************************************
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
***********************************************************************************
* OWeb is a simple Object PHP FrameWork
* ===============================================================================
* Version:		              0.2.5a
* Author	                  Oliver de Cramer (oliverde8 at gmail.com)
**********************************************************************************/

namespace OWeb;

if(!defined('OWEB_DIR_MAIN'))define('OWEB_DIR_MAIN', "OWeb");
if(!defined('OWEB_DIR_CONFIG'))define('OWEB_DIR_CONFIG', "config.ini");
if(!defined('OWEB_DIR_LANG'))define('OWEB_DIR_LANG', "lang");
if(!defined('OWEB_DEFAULT_LANG'))define('OWEB_DEFAULT_LANG', "fr");

if(!defined('OWEB_DIR_VUES'))define('OWEB_DIR_VUES', "vues");
if(!defined('OWEB_DIR_SVUES'))define('OWEB_DIR_SVUES', "sVue");
if(!defined('OWEB_DIR_MODELES'))define('OWEB_DIR_MODELES', "modele");
if(!defined('OWEB_DIR_CONTROLEURS'))define('OWEB_DIR_CONTROLEURS', "controleurs");
if(!defined('OWEB_DIR_EXTENSIONS')) define('OWEB_DIR_EXTENSIONS','extensions');
if(!defined('OWEB_DIR_TEMPLATES')) define('OWEB_DIR_TEMPLATES','templates');

// Les controleurs par default
if(!defined('OWEB_DEFAULT_CONTROLEUR')) define('OWEB_DEFAULT_CONTROLEUR','home');

// Les Fichier pour le HTML par Default
if(!defined('OWEB_HTML_DIR_CSS')) define('OWEB_HTML_DIR_CSS','Sources/css');
if(!defined('OWEB_HTML_DIR_JS')) define('OWEB_HTML_DIR_JS','Sources/js');

require_once OWEB_DIR_MAIN.'/autoLoader.php';

use OWeb\gerer\Reglages as GerreurReglages;
use OWeb\gerer\Extensions as GerreurExtensions;
use OWeb\Gerer\Evenments as GerreurEvenment;
use OWeb\gerer\Controleurs as GerreurControleurs;

/**
 *
 * @author De Cramer Oliver
 */
class OWeb {

	//L'instance OWeb
	private static $instance = null;

	 //Les variables contenant les tableaux associatifs des valeurs passÃƒÂ©es au script courant via les paramÃƒÂ¨tres d'URL.
    private $_get;
    private $_post;
    private $_files;
	private $_cookies;
    private $_server;
	private $_adresseVisiteur;

	//Les Gerreurs
	private $gerer_reglages;
	private $gerer_extensions;
	private $gerer_evenment;
	private $gerer_controleurs;

    public function __construct(&$get,&$post, &$files, &$cookies, &$server, $adrVisiteur) {

		if(self::$instance != null){
			throw new Exception("OWeb ne peut avoir qu'une seule instance.");
		}else{
			self::$instance = $this;
		}

        //Init Autoloader
        autoLoader::Init();

        //Variables d'environement
        $this->_get= $get;
        $this->_post= $post;
        $this->_files= $files;
		$this->_cookies = $cookies;
        $this->_server= $server;
		$this->_adresseVisiteur = $adrVisiteur;

		//Initialiser le gerreur d'exception et d'erreur
		//error_reporting(E_ALL);
		
		
		//Initialiser le gerreur d'evenment
		$this->gerer_evenment = GerreurEvenment::Init();

		//Initialiser le gerreur d'extension
		$this->gerer_extensions = GerreurExtensions::Init();

		//Initialiser le gerreur de controleurs
		$this->gerer_controleurs = GerreurControleurs::Init();

		//\OWeb\gerer\Exception::Init();

		$this->gerer_evenment->envoyerEvenment('Init@OWeb');

		//Initialiser et Chargent les Reglages;
		$this->chargerReglages();
		
		$this->gerer_evenment->envoyerEvenment('Loaded@OWeb');
    }

	public static function getInstance(){
		return self::$instance;
	}

	private function chargerReglages(){
		//Initialisation du Gerreur de Reglages
		$this->gerer_reglages = GerreurReglages::Init();

		$reglage = $this->gerer_reglages->chargerReglage($this);

		//Charger les Extension
		 if(isset($reglage["extensions"]) && !empty($reglage["extensions"])){
            foreach($reglage["extensions"] as $ext){
				$this->gerer_extensions->getExtension($ext);
			}
        }
	}
	
	public function gogo($template=""){
		if(isset($this->_get['mode']) && $this->_get['mode'] == 'API'){
			
			if(isset($this->_get['plugin'])){
				$this->gerer_extensions->goApi($this->_get['plugin']);
			}


		}else if(isset($this->_get['mode']) && $this->_get['mode'] == 'Page'){
			$this->gerer_evenment->envoyerEvenment("AffciherContenu_Debut@OWeb");
			gerer\Controleurs::getInstance()->afficher();
			$this->gerer_evenment->envoyerEvenment("AffciherContenu_Fin@OWeb");
		}else{
			$this->afficher($template);
		}
	}
	
	public function afficher($template=""){

        if($template == "")
            $this->gerer_controleurs->afficher();
        else{
            $this->loadTemplate($template);
        }
    }

	private function loadTemplate($template){
        new Template($template, $this->gerer_evenment);
    }


	public function getGet(){ return $this->_get; }
    public function getPost(){ return $this->_post; }
    public function getFiles(){ return $this->_files; }
	public function getCookie(){ return $this->_cookies; }
    public function getServer(){ return $this->_server; }
	public function getAdresseVisiteur(){ return $this->_adresseVisiteur; }
}
?>
