<?php

namespace OWeb\gerer;

class Exception {

	private static $instance = NULL;

	private $_erreures = array();
	private $_exceptions = array();

	private $controleurs;

	public static function Init() {
		if (self::$instance == NULL)
			self::$instance = new self();
		return self::$instance;
	}

	public static function getInstance(){
		return self::$instance;
	}

	function __construct() {
		$this->controleurs = Controleurs::getInstance();
		set_exception_handler(array($this, 'enregistrerException'));
		set_error_handler(array($this, 'enregistrerErreur'));
	}


	public function enregistrerException($exception) {
		$this->_exceptions[] = $exception;
		$this->controleurs->forcerControleur("Exception");
		$this->controleurs->forcerAffichage();
		return true;
	}

	public function enregistrerErreur($errno, $errstr, $errfile, $errline) {
		if (!(error_reporting() & $errno)) {
			// Ce code d'erreur n'est pas inclus dans error_reporting()
			return;
		}

		$this->_erreures[] = array($errno, $errstr, $errfile, $errline);
		switch ($errno) {

			case E_WARNING :
			case E_PARSE :
			case E_NOTICE :
			case E_CORE_WARNING :
			case E_COMPILE_WARNING :
			case E_USER_WARNING :
			case E_USER_NOTICE :
			case E_STRICT :
				break;
			case E_RECOVERABLE_ERROR :
			case E_ERROR :
			case E_USER_ERROR :
			case E_COMPILE_ERROR :
			case E_CORE_ERROR :
			default:
				$this->controleurs->forcerControleur("Exception");
				break;
		}

		/* Ne pas exécuter le gestionnaire interne de PHP */
		return true;
	}

	public function get_erreures() {
	 return $this->_erreures;
	}

	public function get_exceptions() {
	 return $this->_exceptions;
	}

	function __destruct(){
		/*if(!empty($this->_erreures))print_r($this->_erreures);
		if(!empty($this->_exceptions))\print_r($this->_exceptions);*/
	}

}

?>
