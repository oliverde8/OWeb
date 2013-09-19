<?php

namespace OWeb;
/**
 *
 * @author De Cramer Oliver
 */
class autoLoader {

	private static $instance = NULL;

	private $nameSpaces = array();

	 public static function Init() {
        if (self::$instance == NULL)
            self::$instance = new self();

        return self::$instance;
    }

	public function __construct() {
        spl_autoload_register(array($this, 'autoload'));

		//Add default nameSpaces to autoLoad
		$this->nameSpaces['OWeb'] = OWEB_DIR_MAIN;

		$this->nameSpaces['Controleur'] = OWEB_DIR_CONTROLEURS;
		$this->nameSpaces['Vue'] = OWEB_DIR_VUES;
		$this->nameSpaces['Modele'] = OWEB_DIR_MODELES;
		$this->nameSpaces['modele'] = OWEB_DIR_MODELES;
		$this->nameSpaces['sVue'] = \OWEB_DIR_SVUES;

		$this->nameSpaces['Extension'] = OWEB_DIR_EXTENSIONS;
    }

	public function autoload($class, $exploded = null){

		if($exploded == null)
			$exploded = explode('\\', $class);
		
		
		//On controle voir si c'est a notre AutoLoader de gerer ou pas.
		if(!isset($this->nameSpaces[$exploded[0]]))
			return false;
		

		//On controle si la classe existe et on recupere le fichier
		$file = $this->classExists($class, $exploded);
		if(!$file)
			return false;

		//Tout va bien on va charger la classe.
		require_once $file;
		spl_autoload($class);
        return true;
	}

	public function classExists($class, $exploded = null){

		if($exploded == null)
			$exploded = explode('\\', $class);

		$i = 1;
		$file = '';
		while($i < \sizeof($exploded)){
			$file .= '/'.$exploded[$i];
			$i++;
		}
		$file .= '.php';
		
		if(\file_exists($this->nameSpaces[$exploded[0]].$file))
			return $this->nameSpaces[$exploded[0]].$file;

		if(\file_exists(OWEB_DIR_MAIN.'/defaults/'.$this->nameSpaces[$exploded[0]].$file))
			return OWEB_DIR_MAIN.'/defaults/'.$this->nameSpaces[$exploded[0]].$file;

		return false;

	}


}
?>
