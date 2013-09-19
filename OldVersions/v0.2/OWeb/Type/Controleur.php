<?php

namespace OWeb\Type;

use OWeb\Gerer\Controleur as GControleur;
use OWeb\Gerer\Extensions as GExtensions;
use OWeb\Gerer\Reglages as GReglages;
use OWeb\Gerer\Erreur as GErreur;
use OWeb\Gerer\Evenments;
use OWeb\Vue;

/**
 * Tous les controleur doivent extend cette classe.
 *
 * @author De Cramer Oliver
 */
abstract class Controleur {

	protected $gereur_erreurs;
	protected $gereur_controleurs;
	protected $gereur_extensions;
	protected $gereur_reglages;
	protected $OWeb;
	private $peutEtreMain;
	protected $vue;
	//Carateristique du Controleur
	private $_nom;
	private $_auteur;
	private $_version;
	private $_description;
	private $_website;
	//d
	private $actions;
	private $evenments;
	private $dependence;

	/**
	 *
	 * @param OWeb $oweb
	 * @param OWeb_main_Gerer_Erreur $erreures
	 * @param OWeb_main_Gerer_Controleur $controleurs
	 * @param OWeb_main_Gerer_Extensions $extension
	 * @param OWeb_main_Gerer_Reglages $reglages
	 */
	function __construct(OWeb &$oweb, GErreur &$erreures, GControleur &$controleurs, GExtensions &$extension, GReglages &$reglages) {

		$this->_nom = get_class($this);
		$this->_description = 'no Description';

		$this->gereur_erreurs = $erreures;
		$this->gereur_controleurs = $controleurs;
		$this->gereur_reglages = $reglages;
		$this->gereur_extensions = $extension;
		$this->OWeb = $oweb;

		$this->init();
		//Et Hop on va initier la vue on va en avoir besoin :D
		$this->vue = new Vue($this->_nom, $this->OWeb);
	}

	/**
	 * Va initialiser le controleur.
	 */
	abstract protected function init();

	/**
	 * Afficher, cette fonction va cree tous les elements pour pouvoir faire l'affichage
	 */
	abstract protected function afficher();

	/**
	 * Fonction appeler quand OWeb est initier.
	 * Faut savoir que OWeb s'initialise apres les controleurs
	 */
	public function OWeb_Init() {

		if (!empty($this->dependence)) {
			foreach ($this->dependence as $dep) {
				$ext = $this->gereur_extension->getExtension($dep->name);
				if (!$ext) {
					/* $this->gereur_erreurs->ajoutErreur("OWeb/types/controleur.php",
					  "dependence",
					  "Impossible de charger l'extension : ".$dep->name,
					  "Le controleur ".$this->nom." EN a basoin pour fonctionner",
					  Erreur::$critic); */
				} else {
					$name = "ext_" . $dep->name;
					$this->$name = $ext;
				}
			}
		}
	}

	/*	 * ********************************************
	  Les fonction Protected

	 *
	 */

	/**
	 *
	 * @param Boolean $peutEtreMain
	 */
	protected function setpeutEtreMain($peutEtreMain) {
		$this->peutEtreMain = $peutEtreMain;
	}

	/**
	 * Permet de specifier le nom de celui qui a cree le controleur
	 *
	 * @param <type> Nom de l'auteur du controleur
	 */
	protected function setAuteur($auteur) {
		$this->_auteur = $auteur;
	}

	/**
	 * Permet de specifier la version du controleur
	 *
	 * @param <type> La version du controleur
	 */
	protected function setVersion($in_version) {
		$this->_version = $in_version;
	}

	/**
	 *
	 * @param <type> description du controleur
	 */
	protected function setDescription($desc) {
		$this->_description = $desc;
	}

	/**
	 *
	 * @param <type> Site web sur les detailles du controleur
	 */
	protected function setWebsite($web) {
		$this->_website = $web;
	}

	/**
	 * Ajouter des evenment au qu'elle ce controleur doit repondre
	 *
	 * @param <type> Nom de l'evenment
	 * @param <type> La fonction a appeler
	 */
	protected function addEvenment($Nomevent, $fonction) {
		Evenments::addEvenment($Nomevent, $this, $fonction);
	}

	/**
	 *
	 * @param <type> No de l'evenment
	 * @param <type> La fonction a appeler
	 */
	protected function addAction($action, $nom_func) {
		$this->actions[$action] = $nom_func;
	}

	protected function ajoutDepandence($plugin_name, $min_ver = null, $max_ver = null) {
		$this->dependence[] = new Depandence($plugin_name, $min_ver, $max_ver);
	}

	/*	 * ********************************************
	  Les fonction Public
	 * ******************************************* */

	public function estMain() {
		return $this->peutEtreMain;
	}

	public function get_Auteur() {
		return $this->_auteur;
	}

	public function get_Version() {
		return $this->_version;
	}

	public function get_Description() {
		return $this->_description;
	}

	public function get_WebSite() {
		return $this->_website;
	}

	public function DoAction($action, $estPost) {
		if ($estPost)
			$type = "post";
		else
			$type = "get";

		if (isset($this->actions[$action])) {
			call_user_func_array(array($this, $this->actions[$action]), array("type" => $type));

			$param = array("type" => $type,
				"action" => $action,
				"class" => $this,
				"class_name" => $this->_nom,
				"fonction" => $this->actions[$action]);

			Evenments::envoyerEvenment("Action_Reponse@OWeb", $param);
		}
	}

	protected function addEnTete(int $type, String $fichier){
		\OWeb\Gerer\enTete::ajoutEnTete($type, $fichier);
	}

	public function afficherPage() {

		//Et On demande d'abord a notre controleur d'afficher, en faite il va seulment preparer les donnees
		$this->afficher();

		//Maintenant on fait l'affichage
		$this->vue->afficher();
	}

}

?>
